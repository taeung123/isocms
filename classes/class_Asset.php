<?php

/**
 * Class Asset
 *
 * Asset Registry dùng để quản lý toàn bộ CSS / JS của 1 request.
 *
 * Nguyên tắc:
 * - Block / Module chỉ ĐĂNG KÝ asset (register)
 * - Không render HTML trong block / module
 * - Entry point (index.php) là nơi DUY NHẤT lấy danh sách asset
 * - index.tpl là nơi DUY NHẤT render <link> / <script>
 *
 * Class sử dụng static registry để:
 * - Tránh dùng global
 * - Tránh trùng file
 * - Dễ mở rộng (priority, bundle, condition)
 */
class Asset
{
    /* ==========================================================
     * REGISTRY
     * ========================================================== */

    /**
     * Danh sách CSS theo loại
     *
     * stylesheet : CSS chính, load blocking
     * preload    : CSS preload (critical / page-specific)
     *
     * @var array<string, array<string,bool>>
     */
    protected static array $css = [
        'stylesheet' => [],
        'preload'    => [],
    ];

    /**
     * Danh sách JS theo loại
     *
     * defer : tải song song, chạy sau DOM parse
     * async : tải song song, chạy ngay khi load xong
     *
     * @var array<string, array<string,bool>>
     */
    protected static array $js = [
        'defer' => [],
        'async' => [],
    ];

    /* ==========================================================
     * INTERNAL ADD METHODS
     * ========================================================== */

    /**
     * Thêm 1 hoặc nhiều file CSS vào registry
     *
     * @param string|array $files  Đường dẫn CSS (string hoặc array)
     * @param string       $type   stylesheet | preload
     *
     * @return void
     */
    protected static function addCss(string|array $files, string $type): void
    {
        foreach ((array)$files as $file) {
            if (!empty($file)) {
                // Dùng key để tự động loại trùng
                self::$css[$type][$file] = true;
            }
        }
    }

    /**
     * Thêm 1 hoặc nhiều file JS vào registry
     *
     * @param string|array $files  Đường dẫn JS (string hoặc array)
     * @param string       $type   defer | async
     *
     * @return void
     */
    protected static function addJs(string|array $files, string $type): void
    {
        foreach ((array)$files as $file) {
            if (!empty($file)) {
                self::$js[$type][$file] = true;
            }
        }
    }

    /* ==========================================================
     * PUBLIC API – CSS
     * ========================================================== */

    /**
     * Đăng ký CSS chính (load blocking)
     *
     * Dùng cho:
     * - CSS layout
     * - CSS core
     * - CSS dùng ngay khi render page
     *
     * @param string|array $files
     * @return void
     */
    public static function css(string|array $files): void
    {
        self::addCss($files, 'stylesheet');
    }

    /**
     * Đăng ký CSS preload
     *
     * Dùng cho:
     * - CSS page-specific
     * - CSS above-the-fold
     * - CSS dùng khi có interaction
     *
     * ⚠ Không nên preload quá nhiều file
     *
     * @param string|array $files
     * @return void
     */
    public static function cssPreload(string|array $files): void
    {
        self::addCss($files, 'preload');
    }

    /* ==========================================================
     * PUBLIC API – JS
     * ========================================================== */

    /**
     * Đăng ký JS defer (khuyến nghị dùng mặc định)
     *
     * - Tải song song với HTML
     * - Thực thi sau khi DOM parse xong
     *
     * @param string|array $files
     * @return void
     */
    public static function js(string|array $files): void
    {
        self::addJs($files, 'defer');
    }

    /**
     * Đăng ký JS async
     *
     * - Tải song song
     * - Thực thi ngay khi load xong
     *
     * Dùng cho:
     * - Analytics
     * - Tracking
     * - Script không phụ thuộc DOM
     *
     * @param string|array $files
     * @return void
     */
    public static function jsAsync(string|array $files): void
    {
        self::addJs($files, 'async');
    }

    /* ==========================================================
     * GETTERS – ENTRY POINT ONLY
     * ========================================================== */

    /**
     * Lấy danh sách CSS stylesheet
     *
     * Chỉ gọi tại ENTRY POINT (index.php)
     *
     * @return string[]
     */
    public static function getCssStylesheet(): array
    {
        return array_keys(self::$css['stylesheet']);
    }

    /**
     * Lấy danh sách CSS preload
     *
     * Chỉ gọi tại ENTRY POINT (index.php)
     *
     * @return string[]
     */
    public static function getCssPreload(): array
    {
        return array_keys(self::$css['preload']);
    }

    /**
     * Lấy danh sách JS defer
     *
     * @return string[]
     */
    public static function getJsDefer(): array
    {
        return array_keys(self::$js['defer']);
    }

    /**
     * Lấy danh sách JS async
     *
     * @return string[]
     */
    public static function getJsAsync(): array
    {
        return array_keys(self::$js['async']);
    }

    /* ==========================================================
     * RESET – OPTIONAL
     * ========================================================== */

    /**
     * Reset toàn bộ asset (dùng cho test / debug / multi-render)
     *
     * @return void
     */
    public static function reset(): void
    {
        self::$css = [
            'stylesheet' => [],
            'preload' => [],
        ];
        self::$js = [
            'defer' => [],
            'async' => [],
        ];
    }
}
