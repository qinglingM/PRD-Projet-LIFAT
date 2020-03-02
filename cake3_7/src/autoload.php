<?php
function autoloader($dir){
    spl_autoload_register(function($name) use ($dir){
        $name = str_replace('\\',DIRECTORY_SEPARATOR,$name);
        require $dir.DIRECTORY_SEPARATOR.$name.'.php';
    });
}
define('ROOT',__DIR__);
autoloader(ROOT);

