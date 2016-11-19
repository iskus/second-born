<?php
/**
 * Created by PhpStorm.
 * User: iskus
 * Date: 12.06.15
 * Time: 17:48
 */

namespace app\controller;


use core\Controller;
use core\database\Db;
use core\Model;
use core\sources\UsefulData;


class Test extends Controller {
    public $fields;
    public $model;

    public function __construct() {

        $this->parser = new ParserYopta();
        $this->model = new Model();
        parent::__construct();
    }


    public function index()
    {
    }


}