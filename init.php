<?php

//require __DIR__ . '/header.php';

spl_autoload_register(function($class) {
    $relativeFilename = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $absoluteFile     = __DIR__ . "/classes/{$relativeFilename}.php";

    if (is_file($absoluteFile) === true) {
        require $absoluteFile;
    }
});