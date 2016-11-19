<?php
spl_autoload_register(
    function ($className) {echo $className.' ';
        require_once PATH_TO_ROOT
            . '/' . str_replace('\\', '/', $className) . '.php';
    }
);