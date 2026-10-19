<?php
class CsrfHelper
{
    /**
     * Session key
     */
    const SESSION_KEY = '__csrf_token';

    /**
     * Sinh token
     */
    public static function generate()
    {
        if (empty($_SESSION[self::SESSION_KEY])) {
            $_SESSION[self::SESSION_KEY] = bin2hex(random_bytes(32));
        }

        return $_SESSION[self::SESSION_KEY];
    }

    /**
     * Lấy token hiện tại
     */
    public static function getToken()
    {
        return self::generate();
    }

    /**
     * Verify token
     */
    public static function verify($token)
    {
        if (empty($_SESSION[self::SESSION_KEY])) {
            return false;
        }

        return hash_equals(
            $_SESSION[self::SESSION_KEY],
            (string)$token
        );
    }

    /**
     * Regenerate
     */
    public static function regenerate()
    {
        $_SESSION[self::SESSION_KEY] =
            bin2hex(random_bytes(32));

        return $_SESSION[self::SESSION_KEY];
    }
}