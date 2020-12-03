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
        forward_static_call_array("$class::set", $args);

    }

    public static function get()
    {
        $args = func_get_args();
        $args[] = "GET";
        $class = __CLASS__;
        forward_static_call_array("$class::set", $args);
    }

    private static function set($route, $action, $type = "GET")
    {
        self::$validRouts[] = $route;
        $final_callable_method = null;

        if (is_array($action)) {
            if (sizeof($action) != 2) {
                throw new Exception("action must Be Array Of Size 2 , [ Class_Path , method inside this class ]");
            }
            list($controller, $method) = $action;
            $controller_object = new $controller();
            $final_callable_method = [$controller_object, $method];
        } elseif (is_callable($action)) {
            $final_callable_method = $action;
        } else {
            throw new Exception("action must Be Array Or function");
        }

        if ($_GET['action_url'] == $route) {
            $REQUEST_METHOD = strtoupper($_SERVER['REQUEST_METHOD']);
            if ($REQUEST_METHOD != strtoupper($type)) {
                throw new Exception("the Method $REQUEST_METHOD is not supported for this route");
            }
            call_user_func($final_callable_method, []);
        }

    }
}
