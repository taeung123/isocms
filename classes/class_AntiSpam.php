<?php
class AntiSpam{
    private static $tmpPath   = __DIR__ . '/../tmp/spam/';
    private static $queuePath = __DIR__ . '/../tmp/queue/';
    /* ðŸ” Äá»•i secret nÃ y tháº­t dÃ i */
    //private static $secret = "CHANGE_TO_REAL_SECRET_KEY_123456789";
    private static $secret = ENCRYPTION_KEY;//config
    private static $lastError = '';
    private static $cleanupInterval = 3600; // 1h
    /* ================= INIT =================  */
    
    public static function init()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!is_dir(self::$tmpPath)) {
            mkdir(self::$tmpPath, 0777, true);
        }
        if (!is_dir(self::$queuePath)) {
            mkdir(self::$queuePath, 0777, true);
        }
        self::runCleanupIfNeeded();
    }
    /* ================= ERROR ================= */
    private static function setError($msg)
    {
        self::$lastError = $msg;
        self::log($msg);
        return false;
    }
    public static function getLastError()
    {
        return self::$lastError;
    }
    /* ================= CSRF (MULTI TOKEN) ================= */
    private static function createCSRF()
    {
        if (empty($_SESSION['csrf_tokens'])) {
            $_SESSION['csrf_tokens'] = [];
        }
        $token =
            bin2hex(random_bytes(32));
        $_SESSION['csrf_tokens'][$token] =
            time();
        /* giá»¯ tá»‘i Ä‘a 10 token */
        if (count($_SESSION['csrf_tokens']) > 10) {
            array_shift($_SESSION['csrf_tokens']);
        }
        return $token;
    }
    public static function getCSRF()
    {
        return self::createCSRF();
    }
    public static function validateCSRF($token)
    {
        if (
            empty($token) ||
            empty($_SESSION['csrf_tokens'][$token])
        ) {
            return self::setError(
                "Invalid CSRF"
            );
        }
        $time =
            $_SESSION['csrf_tokens'][$token];
        if (
            time() - $time > 600
        ) {
            unset(
                $_SESSION['csrf_tokens'][$token]
            );
            return self::setError(
                "CSRF expired"
            );
        }
        /* one-time token */
        unset(
            $_SESSION['csrf_tokens'][$token]
        );
        return true;
    }
    /* ================= SIGNATURE ================= */
    public static function getSignature($formTime)
    {
        return hash_hmac(
            'sha256',
            $formTime,
            self::$secret
        );
    }
    public static function validateSignature(
        $signature,
        $formTime
    ) {
        if (
            empty($signature) ||
            empty($formTime)
        ) {
            return self::setError(
                "Invalid signature"
            );
        }
        $expected =
            hash_hmac(
                'sha256',
                $formTime,
                self::$secret
            );
        if (
            !hash_equals(
                $expected,
                $signature
            )
        ) {
            return self::setError(
                "Invalid signature"
            );
        }
        return true;
    }
    /* ================= RATE LIMIT ================= */
    public static function rateLimit(
        $seconds = 5
    ) {
        $key =
            md5(
                $_SERVER['REMOTE_ADDR']
                    . $_SERVER['HTTP_USER_AGENT']
            );
        $file =
            self::$tmpPath .
            "limit_" . $key;
        $now = time();
        if (file_exists($file)) {
            $last =
                (int)
                file_get_contents($file);
            if (
                $now - $last
                < $seconds
            ) {
                return self::setError(
                    "Too fast request"
                );
            }
        }
        file_put_contents(
            $file,
            $now,
            LOCK_EX
        );
        return true;
    }
    /* ================= FORM TIME ================= */
    public static function checkFormTime($time)
    {
        if (
            empty($time) ||
            !ctype_digit((string)$time)
        ) {
            return self::setError(
                "Invalid form time"
            );
        }
        if (
            time() - $time < 2
        ) {
            return self::setError(
                "Too fast submit"
            );
        }
        if (
            time() - $time > 3600
        ) {
            return self::setError(
                "Form expired"
            );
        }
        return true;
    }
    /* ================= HONEYPOT ================= */
    public static function checkHoneypot($value)
    {
        if (!empty($value)) {
            return self::setError(
                "Spam honeypot"
            );
        }
        return true;
    }
    public static function checkHoneypots($fields)
    {
        foreach ($fields as $field) {
            if (!empty($field)) {
                return self::setError(
                    "Spam honeypot"
                );
            }
        }
        return true;
    }
    /* ================= JS TOKEN ================= */
    public static function createJSToken()
    {
        $time = time();
        $hash =
            hash_hmac(
                'sha256',
                $time,
                self::$secret
            );
        return base64_encode(
            $time . "|" . $hash
        );
    }
    public static function validateJSToken(
        $token
    ) {
        if (empty($token)) {
            return self::setError(
                "No JS token"
            );
        }
        $decoded =
            base64_decode(
                $token,
                true
            );
        if ($decoded === false) {
            return self::setError(
                "Invalid JS token"
            );
        }
        $parts =
            explode("|", $decoded);
        if (count($parts) !== 2) {
            return self::setError(
                "Invalid JS token"
            );
        }
        list($time, $hash) =
            $parts;
        if (
            !ctype_digit($time)
        ) {
            return self::setError(
                "Invalid JS time"
            );
        }
        $expected =
            hash_hmac(
                'sha256',
                $time,
                self::$secret
            );
        if (
            !hash_equals(
                $expected,
                $hash
            )
        ) {
            return self::setError(
                "Fake JS token"
            );
        }
        if (
            time() - (int)$time > 3600
        ) {
            return self::setError(
                "JS expired"
            );
        }
        return true;
    }
    /* ================= FINGERPRINT ================= */
    public static function checkFingerprint(
        $fp,
        $limit = 10
    ) {
        if (empty($fp)) {
            return self::setError(
                "No fingerprint"
            );
        }
        $key =
            md5(
                $_SERVER['REMOTE_ADDR']
                    . $fp
            );
        $file =
            self::$tmpPath .
            "fp_" . $key;
        $count = 1;
        if (file_exists($file)) {
            $data =
                json_decode(
                    file_get_contents($file),
                    true
                );
            if ($data) {
                if (
                    time()
                    - $data['time']
                    > 3600
                ) {
                    $count = 1;
                } else {
                    $count =
                        $data['count'] + 1;
                    if (
                        $count > $limit
                    ) {
                        return self::setError(
                            "Too many submits"
                        );
                    }
                }
            }
        }
        file_put_contents(
            $file,
            json_encode([
                'count' => $count,
                'time' => time()
            ]),
            LOCK_EX
        );
        return true;
    }
    /* ================= MAIL QUEUE ================= */
    public static function queueMail($data)
    {
        $file =
            self::$queuePath .
            "mail_" .
            time() . "_" .
            bin2hex(
                random_bytes(4)
            );
        file_put_contents(
            $file,
            json_encode($data),
            LOCK_EX
        );
        return true;
    }
    /* ================= CLEANUP ================= */
    private static function runCleanupIfNeeded()
    {
        $file =
            self::$tmpPath .
            "cleanup.lock";
        $now = time();
        if (file_exists($file)) {
            $last =
                (int)
                file_get_contents($file);
            if (
                $now - $last
                < self::$cleanupInterval
            ) {
                return;
            }
        }
        self::cleanup();
        file_put_contents(
            $file,
            $now,
            LOCK_EX
        );
    }
    private static function cleanup()
    {
        $files =
            array_merge(
                glob(self::$tmpPath . "*"),
                glob(self::$queuePath . "*")
            );
        foreach ($files as $file) {
            if (
                filemtime($file)
                < time() - 86400
            ) {
                unlink($file);
            }
        }
    }
    /* ================= LOG ================= */
    private static function log($msg)
    {
        $file =
            self::$tmpPath .
            "log_" .
            date("Ymd") .
            ".log";
        $line =
            date("Y-m-d H:i:s") .
            " | " .
            $_SERVER['REMOTE_ADDR'] .
            " | " .
            $msg .
            PHP_EOL;
        file_put_contents(
            $file,
            $line,
            FILE_APPEND |
                LOCK_EX
        );
    }
}
