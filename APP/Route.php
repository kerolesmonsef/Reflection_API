<?php


namespace App;


use Exception;

class Route
{
    public static $validRouts = [];

    public static function post()
    {

        $args = func_get_args();
        $args[] = "POST";
        $class = __CLASS__;
        self::set(...$args);

    }

    public static function get()
    {
        $args = func_get_args();
        $args[] = "GET";
        $class = __CLASS__;
        //forward_static_call_array("$class::set", $args);
        self::set(...$args);
    }

    private static function set($route, $action, $type = "GET")
    {
        self::$validRouts[] = [
            'method' => $type,
            'route' => $route,
            'action' => $action,
        ];
    }
}
