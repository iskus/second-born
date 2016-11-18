<?php

namespace app\controller\shadow;

class Index extends Shadow
{
    public function index()
    {
        $this->view->createContent();
    }

}