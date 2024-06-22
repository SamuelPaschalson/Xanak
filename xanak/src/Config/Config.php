<?php

namespace Xanak\Config;

class Config
{
    protected static $settings = [];

    public static function load($file)
    {
        if (file_exists($file)) {
            $settings = require $file;
            self::$settings = array_merge(self::$settings, $settings);
        }
    }

    public static function get($key, $default = null)
    {
        return self::$settings[$key] ?? $default;
    }

    public static function env($key, $default = null)
    {
        return $_ENV[$key] ?? $default;
    }
}
