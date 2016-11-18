<?php
namespace core;

use core\sources\UsefulData;

class Router
{
    private $controller = 'Index',
        $action = 'index',
        $params = [];

    //TODO
    function __construct()
    {
        $route = explode('/', UsefulData::getRequest('route'));
        $mainController = (isset($route[0]) && $route[0]) ? $route[0] : 0;
//        var_dump(UsefulData::getRequest('route'), $route);
        if ($mainController && $route != '/') {

            $this->controller = ucfirst($route[0]);
            $step = 0;

            if ($this->controller == 'Shadow') {
                $this->controller = strtolower($this->controller);
                $this->controller .= $route[1] ? "\\" . ucfirst($route[1]) : "\\Index";
                $step = 1;
            }

            if (count($route) > (1 + $step)) {

                foreach ($route as $key => $val) {

                    if ($key == (1 + $step)) {
                        $this->action =
                            $val ? $val : 'index';

                    } elseif ($key > (1 + $step)) {
                        $this->params[] = $val;
                    }
                }
            }

        }
    }

    /**
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

}