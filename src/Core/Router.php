<?php

namespace Core;

class Router
{
    private static $routes = array(
        'GET' => array(),
        'POST' => array(),
    );

    public static function start()
    {
        $request_method = $_SERVER['REQUEST_METHOD'];
        $parsed_url = parse_url($_SERVER['REQUEST_URI'])['path'];

        foreach (self::$routes[$request_method] as $route) {
            if ($parsed_url === $route['url']) {
                $route['callback']();
            }
        }
    }

    public static function get($url, $callback)
    {
        self::add('GET', $url, $callback);
    }

    public static function add($method, $url, $callback)
    {
        self::$routes[$method][] = array(
            'url' => $url,
            'callback' => $callback,
        );

    }

}
