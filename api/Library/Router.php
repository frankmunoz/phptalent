<?php

class Router
{

    private static $routes = [];

    const NOT_FOUND = 404;

    private function __construct()
    {
        
    }

    public static function route($route)
    {
        foreach ($route AS $pattern => $content) {
            foreach ($content AS $method => $controller) {
                $pattern = preg_replace('/^\/(\W+)\/$/', '(:any)', $pattern);
                $pattern = preg_replace('/(\d+$)/', '(:num)', $pattern);
                self::$routes[$pattern][$method] = $controller;
            }
        }
    }

    public static function execute($url)
    {
        $uriNum = self::ifsetor(preg_replace('/(\d+$)/', '(:num)', $url));
        $uriStr = self::ifsetor(preg_replace('/\w+$/', '(:any)', $url));
        if (isset(self::$routes[$uriNum][self::getMethod()])) {
            self::callBack(self::$routes[$uriNum][self::getMethod()]);
        } else if (isset(self::$routes[$uriStr][self::getMethod()])) {
            self::callBack(self::$routes[$uriStr][self::getMethod()]);
        } else {
            header('HTTP/1.0 404 Not Found', true, self::NOT_FOUND);
            die();
        }
    }

    private function callBack($url)
    {
        $uri = explode("/", $url);
        $endPoint = array_pop(explode("/", $url));
        $pathClass = self::ifsetor(implode("/", str_replace($endPoint, '', $uri)));
        $class = array_pop(explode("/", $pathClass));
        $pathClass .= ".php";
        if (file_exists($pathClass)) {
            require_once($pathClass);
            $object = new $class;
            if (method_exists($object, $endPoint)) {
                $object->$endPoint();
            } else {
                header('HTTP/1.0 404 Not Found', true, self::NOT_FOUND);
                die();
            }
        }
    }

    private function ifsetor(&$variable, $default = null)
    {
        return isset($variable) ? trim($variable, '/') : $default;
    }

    private function getMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

}
