<?php
namespace core;

class Controller
{
    /**
     * @var object core\View
     */
    protected $view;

    public function __construct($vars = FALSE)
    {
        $view = APP_FOLDER . '\\view\\' . App::$controller;
        $this->view = new $view();
    }

}