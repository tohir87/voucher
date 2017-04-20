<?php

function internalClassesLoader($className){
    $baseDir = APP_ROOT . 'application/libraries/classes/';
    $classFile = $baseDir .  str_replace('\\', DIRECTORY_SEPARATOR, ltrim($className, '/\\')) . '.php';
    if(file_exists($classFile)){
        include_once $classFile;
    }
}

spl_autoload_register('internalClassesLoader');
