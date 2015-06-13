<?php
function __autoload($class_name) {
    $lib_path = './lib/';
    $class_file = $lib_path . $class_name . ".php";
    require_once $class_file;
}

