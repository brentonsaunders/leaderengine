<?php
spl_autoload_register(function($class) {
    $pos = strrpos($class, '\\');

    if($pos) {
        $class = substr($class, $pos + 1);
    }

    $dirs = scandir(__DIR__);

    foreach($dirs as $dir) {
        $dir = __DIR__ . DIRECTORY_SEPARATOR . $dir;

        if(is_dir($dir) && $dir != '..') {
            $classFile = strtolower($dir . DIRECTORY_SEPARATOR . "$class.php");

            $files = glob($dir . DIRECTORY_SEPARATOR . '*');

            foreach($files as $file) {
                if(strtolower($file) === $classFile) {
                    require_once $file;

                    return true;
                }
            }
        }
    }

    return false;
});