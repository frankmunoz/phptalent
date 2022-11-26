<?php
/**
 * Generates the paths of API endpoints 
 *
 * This deefinition is used to retrieve the data according with the 
 * given endpoint with HTTP Verb. <b>Note:</b> it is not required that
 * the user be currently logged in.
 *
 * @access public
 * @param string $user Francisco Muñoz
 * @return endpoint
 */

$route['api/movies']['get'] = 'Controller/Movie/MovieController/get';
$route['api/movies/retrieve']['get'] = 'Controller/Movie/MovieController/getCollection';
$route['api/movies/filter']['post'] = 'Controller/Movie/MovieController/filter';

Router::route($route);
Router::execute($_SERVER['REQUEST_URI']);
