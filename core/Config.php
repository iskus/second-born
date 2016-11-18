<?php
namespace core;
/**
 * Iskus Anton. Email: iskus1981@yandex.ru
 * IDE PhpStorm. 12.04.2015
 */
final class Config
{
    private static $dbConfigs;

    private function __construct()
    {
    }

    public static function getDbConfigs()
    {
        return self::$dbConfigs;
    }

    public static function setDbConfigs(\ArrayObject $collection)
    {
        self::$dbConfigs = $collection;
    }

    public static function getDbConfig($driver)
    {
        return self::$dbConfigs->offsetGet($driver);
    }

    public static function setDbConfig($key, $value)
    {
        self::$dbConfigs->offsetSet($key, $value);
    }
}