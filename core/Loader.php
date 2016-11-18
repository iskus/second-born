<?php
/**
 * Iskus Anton. Email: iskus1981@yandex.ru
 * IDE PhpStorm. 17.04.2015
 */

namespace core;

class Loader
{
    /**
     * @param $className
     * @param array $params
     * @return object $className
     */
    public static function getLibrary($className, $params = [])
    {
        $pref = 'libs\\';
        $use = $className;
        $path = PATH_TO_LIBS . $className;
        $file = $path . '.php';
        $use = self::recursive($use, $path, $className);
        return $use;
    }

    private static function recursive($use, $path, $className)
    {
        if (is_dir($path) && !is_file($file = $path . '.php')) {
            $use .= '\\' . $className;
            $path .= '/' . $className;
            self::recursive($use, $path, $className);
        } elseif (is_file($path . '.php')) {
            return ['use' => $use, 'path' => $path];
        } else {
            return FALSE;
        }
    }


}