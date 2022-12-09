<?php
/**
 * Generates the paths of API endpoints 
 *
 * This deefinition is used to retrieve the data according with the 
 * given endpoint with HTTP Verb. <b>Note:</b> it is not required that
 * the user be currently logged in.
 * 
 * @version 1.0
 * @author Francisco Muñoz
 * 
 */
session_start();
$requestURI = $_SERVER['REQUEST_URI'];;

$route['api/authentication/logout']['post'] = 'Controller/Authentication/AuthenticationController/logout';
$route['api/authentication/logout']['get'] = 'Controller/Authentication/AuthenticationController/logout';
$route['api/authentication/login']['post'] = 'Controller/Authentication/AuthenticationController/login';
$route['api/authentication/register']['post'] = 'Controller/Authentication/AuthenticationController/post';
if(isset($_SESSION['user'])){
    $route['api/movies']['get'] = 'Controller/Movie/MovieController/get';
    $route['api/movies/retrieve']['get'] = 'Controller/Movie/MovieController/getCollection';
    $route['api/movies/filter']['post'] = 'Controller/Movie/MovieController/filter';    
}
$found = FALSE;
foreach($route AS $key => $value){
    if(strstr($requestURI,$key)){
        $found = TRUE; 
    }
}

if(!$found){
    $requestURI = 'api/authentication/logout';
}

Router::route($route);
Router::execute($requestURI);

