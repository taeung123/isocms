<?php
/*======================================================================*\
|| #################################################################### ||
|| # CRM Private By VietISO (support@vietiso.com)                     # ||
|| # ---------------------------------------------------------------- # ||
|| # All Script code in this file is ©2007-2013 VietISO JSC.          # ||
|| # This file may not be redistributed in whole or significant part. # ||
|| # ---------------- ISOCMS IS NOT FREE SOFTWARE ----------------    # ||
|| # http://www.vietiso.com | http://www.vietiso.com/license.html     # ||
|| #################################################################### ||
\*======================================================================*/
class Input
{
    function __construct() {}
    /*
    |--------------------------------------------
    | Protocol (http or https)
    |---------------------------------------------
    */
    public static function protocol(): string
    {
        $https = self::server('HTTPS');
        $secure = !empty($https) && strtolower((string)$https) !== 'off';
        return $secure ? 'https' : 'http';
    }

    /*
    |--------------------------------------------
    | Is AJAX request
    |---------------------------------------------
    */
    public static function isAjax(): bool
    {
        $req = self::server('HTTP_X_REQUESTED_WITH');
        return !empty($req) && strtolower((string)$req) === 'xmlhttprequest';
    }

    /*
    |--------------------------------------------
    | Request method (GET, POST)
    |---------------------------------------------
    */
    public static function method(bool $upper = true): string
    {
        $method = self::server('REQUEST_METHOD', 'GET');
        $method = (string)$method;
        return $upper ? strtoupper($method) : strtolower($method);
    }

    /*
    |--------------------------------------------
    | Check variable exists
    |---------------------------------------------
    */
    public static function exists(?string $var = null, string $type = 'post'): bool
    {
        $type = strtoupper($type);
        if ($type === 'POST') {
            return self::post($var, null, false) !== null;
        }
        if ($type === 'GET') {
            return self::get($var, null, false) !== null;
        }
        return false;
    }

    /*
    |--------------------------------------------
    | Find $_SERVER value
    |---------------------------------------------
    */
    public static function server(string $index = '', $default = null)
    {
        return self::_findFromArray($_SERVER ?? [], $index, $default, false);
    }

    /*
    |--------------------------------------------
    | Referrer
    |---------------------------------------------
    */
    public static function referrer($default = null)
    {
        $referrer = self::server('HTTP_REFERER', $default);
        return $referrer ?? $default;
    }

    /*
    |--------------------------------------------
    | Find $_GET/$_POST merged value
    |---------------------------------------------
    */
    public static function request(?string $item = null, $default = null, bool $xss_clean = true)
    {
        $request = array_merge($_GET ?? [], $_POST ?? []);
        return self::_findFromArray($request, $item, $default, $xss_clean);
    }

    /*
    |--------------------------------------------
    | Find $_POST value
    |---------------------------------------------
    */
    public static function post(?string $var = null, $default = '', bool $notnull = false, bool $xss_clean = true)
    {
        $post = $_POST ?? [];
        $value = self::_findFromArray($post, $var, $default, $xss_clean);
        return $notnull ? (!empty($value) ? $value : $default) : $value;
    }

    /*
    |--------------------------------------------
    | Find $_GET value
    |---------------------------------------------
    */
    public static function get(?string $var = null, $default = '', bool $notnull = false, bool $xss_clean = true)
    {
        $get = $_GET ?? [];
        $value = self::_findFromArray($get, $var, $default, $xss_clean);
        return $notnull ? (!empty($value) ? $value : $default) : $value;
    }

    /*
    |--------------------------------------------
    | Find $_FILES value
    |---------------------------------------------
    */
    public static function file(?string $item = null, $default = null)
    {
        return self::_findFromArray($_FILES ?? [], $item, $default, false);
    }

    /*
    |--------------------------------------------
    | Clean XSS
    |---------------------------------------------
    */
    public static function xssClean($str = '')
    {
        if (is_string($str) && trim($str) === '') {
            return $str;
        }

        if (is_array($str)) {
            foreach ($str as $key => $value) {
                $str[$key] = self::xssClean($value);
            }
            return $str;
        }

        $str = str_replace(
            ['&amp;', '&lt;', '&gt;'],
            ['&amp;amp;', '&amp;lt;', '&amp;gt;'],
            $str
        );

        $str = preg_replace('#(&\#*\w+)[\x00-\x20]+;#u', '$1;', $str);
        $str = preg_replace('#(&\#x*)([0-9A-F]+);*#iu', '$1$2;', $str);
        $str = html_entity_decode($str, ENT_COMPAT, 'UTF-8');

        $str = preg_replace('#(<[^>]+?)(on|xmlns)[^>]*>#iu', '$1>', $str);
        $str = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j\s*a\s*v\s*a\s*s\s*c\s*r\s*i\s*p\s*t\s*:#iu', '$1=$2nojavascript...', $str);
        $str = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*v\s*b\s*s\s*c\s*r\s*i\s*p\s*t\s*:#iu', '$1=$2novbscript...', $str);
        $str = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*-moz-binding\s*:#iu', '$1=$2nomozbinding...', $str);
        $str = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*data\s*:#iu', '$1=$2nodata...', $str);
        $str = preg_replace('#(<[^>]+?)style[^>]*>#iu', '$1>', $str);
        $str = preg_replace('#</*\w+:\w[^>]*>#i', '', $str);

        do {
            $oldstring = $str;
            $str = preg_replace(
                '#</*(applet|meta|xml|blink|link|style|script|embed|object|iframe|frame|frameset|ilayer|layer|bgsound|title|base)[^>]*>#i',
                '',
                $str
            );
        } while ($oldstring !== $str);

        return $str;
    }

    /*
    |--------------------------------------------
    | Internal find helper
    |---------------------------------------------
    */
    private static function _findFromArray(array $array, ?string $item = '', $default = null, bool $xss_clean = true)
    {
        if (empty($array)) {
            return $default;
        }

        if ($item === null || $item === '') {
            $arr = [];
            foreach (array_keys($array) as $key) {
                $arr[$key] = self::_fetchFromArray($array, $key, $default, $xss_clean);
            }
            return $arr;
        }

        return self::_fetchFromArray($array, $item, $default, $xss_clean);
    }

    /*
    |--------------------------------------------
    | Fetch value from array safely
    |---------------------------------------------
    */
    private static function _fetchFromArray(array $array, string $item = '', $default = null, bool $xss_clean = true)
    {
        if (!array_key_exists($item, $array)) {
            return $default;
        }

        $value = $array[$item];
        return $xss_clean ? self::xssClean($value) : $value;
    }
}
