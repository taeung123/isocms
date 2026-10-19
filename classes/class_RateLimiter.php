<?php

class RateLimiter
{
    protected string $storagePath;
    protected int $limit;
    protected int $window;
    protected string $key;
    protected string $ip;
    protected string $endpoint;
    protected int $now;

    public function __construct(array $config = [])
    {
        global $clsISO;

        $this->limit  = (int)($config['limit_request'] ?? 30);
        $this->window = (int)($config['limit_time'] ?? 60);
        $this->storagePath = rtrim(PCMS_DIR . '/ratelimit', '/');
        $this->now = time();

        $this->ip = $this->sanitizeIp($clsISO->getRealIP());
        $this->endpoint = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);

        // file name vẫn là hash
        $this->key = hash('sha256', $this->ip . '|' . $this->endpoint);
    }

    public function check(): void
    {
        $this->ensureDirectory();

        $file = "{$this->storagePath}/{$this->key}.log";

        $fp = fopen($file, 'c+');
        if (!$fp) return;

        flock($fp, LOCK_EX);

        $data = $this->readData($fp);

        if (empty($data)) {
            $data = [
                'ip'         => $this->ip,
                'endpoint'   => $this->endpoint,
                'created_at' => $this->now,
                'requests'   => []
            ];
        }

        // lọc request cũ
        $data['requests'] = $this->filterRecent($data['requests']);

        if (count($data['requests']) >= $this->limit) {
            flock($fp, LOCK_UN);
            fclose($fp);
            $this->reject();
        }

        $data['requests'][] = $this->now;

        $this->writeData($fp, $data);

        flock($fp, LOCK_UN);
        fclose($fp);

        $this->cleanup();
    }

    /* ================= Helpers ================= */

    protected function sanitizeIp(string $ip): string
    {
        return filter_var($ip, FILTER_VALIDATE_IP) ?: '0.0.0.0';
    }

    protected function ensureDirectory(): void
    {
        if (!is_dir($this->storagePath)) {
            mkdir($this->storagePath, 0755, true);
        }
    }

    protected function readData($fp): array
    {
        rewind($fp);
        $raw = stream_get_contents($fp);
        $data = json_decode($raw, true);

        return is_array($data) ? $data : [];
    }

    protected function writeData($fp, array $data): void
    {
        ftruncate($fp, 0);
        rewind($fp);
        fwrite($fp, json_encode($data, JSON_UNESCAPED_SLASHES));
    }

    protected function filterRecent(array $timestamps): array
    {
        $cutoff = $this->now - $this->window;
        return array_values(
            array_filter($timestamps, fn($t) => $t >= $cutoff)
        );
    }

    protected function reject(): void
    {
        http_response_code(429);
        header('Retry-After: ' . $this->window);
        exit('Too many requests');
    }

    protected function cleanup(): void
    {
        $flag = "{$this->storagePath}/.last_cleanup";
        $nowMinute = date('Y-m-d H:i');

        if (@file_get_contents($flag) === $nowMinute) return;
        @file_put_contents($flag, $nowMinute, LOCK_EX);

        foreach (glob($this->storagePath . '/*.log') as $file) {
            if (filemtime($file) < $this->now - 3600) {
                @unlink($file);
            }
        }
    }
}
