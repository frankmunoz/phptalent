<?php
/**
 * Register the class and the paths 
 *
 *
 * @version 1.0
 * @author Francisco Muñoz
 */
spl_autoload_register('autoload');


/**
 * Autoload
 *
 * This method is used to include the paths of the class to be used global in the project
 *
 * @param string $className
 * @return 
 */
function autoload($className) {
    $folder = "Library/";
    if ($className === "AuthenticationController") {
        $folder = "Controller/Authentication/";
    }
    if ($className === "AuthenticationService") {
        $folder = "Model/Authentication/";
    }
    if ($className === "MovieController") {
        $folder = "Controller/Movie/";
    }
    if ($className === "MovieService") {
        $folder = "Model/Movie/";
    }
    $fileName = $folder . $className . ".php";
    if (is_file($fileName)) {
        require $fileName;
    }
}
