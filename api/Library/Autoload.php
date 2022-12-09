<?php

spl_autoload_register('autoload');

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
