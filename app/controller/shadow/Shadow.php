<?php

namespace app\controller\shadow;

use core\App;
use core\Controller;
use core\sources\UsefulData;

class Shadow extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        $logSESS = UsefulData::getRequest('logSESS', 'session');
        if (!$logSESS && App::$controller != 'shadow\Login') {
            header("location: http://" . SITE_URL . "/shadow/login");
            exit;
        }
    }
}