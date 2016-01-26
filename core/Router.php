<?php

namespace core;

class Router
{

    private static $routes = array();
    private static $shortcut = array(
        ':word' => '([A-Za-z0-9-]+)',
        ':any' => '(.+)'
    );

    public static function add($route, $callback, $view = null)
    {
        self::$routes[$route] = array(
            'regex' => self::parseRoute($route),
            'callback' => $callback,
            'view' => $view
        );
    }

    public static function execute($route, $params)
    {
        foreach (self::$routes as $k => $v) {
            $matches = array();
            if ($p = preg_match($v['regex'], $route, $matches)) {
                array_shift($matches);
                if (is_array($v['callback'])) {

                    $controller = $v['callback'][0];
                    $method = $v['callback'][1];
                    if (!empty($_POST)) {
                        $matches[] = $_POST;
                    }

                    $c = new $controller();
                    call_user_func_array(array($c, $method), $matches);
                    return true;
                }
            }
        }
    }

    private static function parseRoute($route)
    {
        foreach (self::$shortcut as $k => $v) {
            $route = str_replace($k, $v, $route);
        }
        return '#^' . $route . '$#';
    }

}
