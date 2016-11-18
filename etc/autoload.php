<?php
spl_autoload_register(
    function ($className) {
        require_once PATH_TO_ROOT
            . '/' . str_replace('\\', '/', $className) . '.php';
    }
);