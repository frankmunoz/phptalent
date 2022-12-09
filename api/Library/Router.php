<?php
/**
 * Manages all events of Paths and Call the Methods Class of API endpoints 
 *
 * This class is used to manage all the paths of API and call the target method in a class
 *
 * @version 1.0
 * @author Francisco Muñoz
 */
class Router
{

    private static $routes = [];

    const NOT_FOUND = 404;

    private function __construct()
    {
        
    }

    /**
     * Route
     *
     * This method is used to build the path of endpoint, could receives
     * parameter like numer or string build in the URI of query 
     *
     * @param $route
     * @return $routes with the endpoint dfefinition 
     */
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

    /**
     * Execute
     *
     * This method is used to call the specific according the path and run it as callback  
     *
     * @param $url
     * @return  
     */
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

    /**
     * Callback
     *
     * This method is used to run the specific method of a specific class 
     * validating if the method and class exists
     *
     * @param $url
     * @return  
     */
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

    /**
     * Ifsetor
     *
     * This method is used to review if exists a param extra aftere the / character in the URI. 
     *
     * @param &$variable, $default = null
     * @return string with the varaiable
     */
    private function ifsetor(&$variable, $default = null)
    {
        return isset($variable) ? trim($variable, '/') : $default;
    }

    /**
     * Get method
     *
     * This method is used to get the HTTP Request method
     *
     * @param
     * @return  
     */
    private function getMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

}
