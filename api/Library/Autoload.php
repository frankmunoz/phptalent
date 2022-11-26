<?php

spl_autoload_register('autoload');

function autoload($className) {
    $folder = "Library/";
    if ($className === "MovieController") {
        $folder = "Controller/Movie/";
    }
    if ($className === "MovieService") {
        $folder = "Model/Movie/";
    }
    if ($className === "HomeController") {
        $folder = "Controller/Home/";
    }
    if ($className === "HomeService") {
        $folder = "Model/Home/";
    }
    if ($className === "PatientController") {
        $folder = "Controller/Patient/";
    }
    if ($className === "PatientService") {
        $folder = "Model/Patient/";
    }
    if ($className === "RoomController") {
        $folder = "Controller/Room/";
    }
    if ($className === "RoomService") {
        $folder = "Model/Room/";
    }
    if ($className === "HospitalService") {
        $folder = "Model/Hospital/";
    }
    $fileName = $folder . $className . ".php";
    if (is_file($fileName)) {
        require $fileName;
    }
}
