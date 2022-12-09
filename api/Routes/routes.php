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

$route['api/authentication/login']['post'] = 'Controller/Authentication/AuthenticationController/login';
$route['api/authentication/logout']['post'] = 'Controller/Authentication/AuthenticationController/logout';
$route['api/authentication/register']['post'] = 'Controller/Authentication/AuthenticationController/post';
$route['api/movies']['get'] = 'Controller/Movie/MovieController/get';
$route['api/movies/retrieve']['get'] = 'Controller/Movie/MovieController/getCollection';
$route['api/movies/filter']['post'] = 'Controller/Movie/MovieController/filter';

Router::route($route);
Router::execute($_SERVER['REQUEST_URI']);
