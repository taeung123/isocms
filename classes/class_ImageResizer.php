<?php

require_once(DIR_INCLUDES . '/InterventionImage/vendor/autoload.php');

use Intervention\Image\ImageManager;

class ImageResizer
{
    protected $uploadPrefix = '/uploads/';
    protected $outputPrefix = '/imgresize/';
    protected $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(['driver' => 'gd']);
    }
    // Trả về và lưu ảnh sau khi được resize
    public function resize($filename = 0, $w = 0, $h = 0)
    {
        if (!$this->isValid($filename)) {
            return "";
        }

        $newPath = $this->getNewPath($filename, $w, $h);
        $absolutePath = $_SERVER['DOCUMENT_ROOT'] . $newPath;

        if (file_exists($absolutePath)) {
            return $newPath;
        }

        try {
            $this->ensureDirectory(dirname($absolutePath));

            $this->manager->make($_SERVER['DOCUMENT_ROOT'] . $filename)
                ->fit($w, $h)
                ->save($absolutePath);
        } catch (Exception $e) {
            return "";
        }

        return file_exists($absolutePath) ? $newPath : "";
    }

    // Check file có tồn tại hay không
    protected function isValid($filename = '')
    {
        return strpos($filename, $this->uploadPrefix) === 0 && $this->fileExists($filename);
    }

    protected function fileExists($filename = '')
    {
        return file_exists($_SERVER['DOCUMENT_ROOT'] . $filename);
    }
    // tạo đường dẫn mới cho ảnh sau khi resize
    protected function getNewPath($filename = '', $w = 0, $h = 0)
    {
        $path = preg_replace('#^' . preg_quote($this->uploadPrefix, '#') . '#', $this->outputPrefix, $filename);
        $info = pathinfo($filename);
        $name = $info['filename'];
        $ext = $info['extension'];
        $dir = dirname($path);

        return "{$dir}/{$name}_{$w}x{$h}.{$ext}";
    }
    // Tạo đường dẫn thư mục ảnh nếu chưa có
    protected function ensureDirectory($dir = '')
    {
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
    }
}
