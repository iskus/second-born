<?php

namespace core;

class App
{
    public static $shadow,
        $controller,
        $action,
        $params;

    public function __construct($c, $a, $p = [])
    {
        self::$controller = $c;
        self::$action = $a;
        self::$params = $p;
        self::$shadow = str_replace(strstr($c, '\\'), '', $c);
    }

    public function run()
    {
        $controller = APP_FOLDER . '\\controller\\' . self::$controller;
        try {
            $run = new $controller();
            $run->{self::$action}(self::$params);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

}