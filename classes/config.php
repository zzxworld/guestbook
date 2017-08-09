<?php
defined('VERSION') or die('deny access');

class Config
{
    protected static $data = [];

    public static function set($key, $value)
    {
        self::$data[$key] = $value;
    }

    public static function get($key, $default=null)
    {
        return arrayFind(self::$data, $key, $default);
    }
}
