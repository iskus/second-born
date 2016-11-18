<?php
/**
 * Created by PhpStorm.
 * User: iskus
 * Date: 12.06.15
 * Time: 17:48
 */

namespace app\controller;


use core\Controller;
use core\Model;
use core\sources\UsefulData;
use libs\ParserYopta;
use app\model\Account;
use app\model\Transfer;
use app\model\Operation;
use app\model\Comission;

class Fintest extends Controller {

    public function index() {
        $seller = new Account((int)UsefulData::getRequest('accountFrom'));
        $buyer = new Account((int)UsefulData::getRequest('accountFrom'));
        $operationsIds = UsefulData::getRequest('operations[]');
        var_dump($seller, $buyer, $operationsIds);
    }

}