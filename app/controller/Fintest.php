<?php
/**
 * Created by PhpStorm.
 * User: iskus
 * Date: 12.06.15
 * Time: 17:48
 */

namespace app\controller;


use app\model\transfer\Operation;
use app\model\transfer\Transfer;
use core\Controller;
use core\sources\UsefulData;

class Fintest extends Controller
{

    public function index()
    {
        error_reporting(E_ALL);
//        for ($i = 0; $i < 100; $i++) {
//            $model = new Model();
//            $model->setDbTable('operation');
//            $o = new \stdClass();
//            $o->title = str_shuffle(implode('', UsefulData::$alphabets['en']));
//            $o->price = (float)rand(1.01, 10000.99);
//            $model->addEntity($o);
//            $a = new \stdClass();
//            $a->title = str_shuffle(implode('', UsefulData::$alphabets['en']));
//            $a->balance = (float)rand(1.01, 10000.99);
//            $model->setDbTable('account');
//            $model->addEntity($a);
//
//        }
//
        $fromId = (int)UsefulData::getRequest('accountFrom', 'GET');
        $toId = (int)UsefulData::getRequest('accountTo', 'GET');
        $operationsIds = UsefulData::getRequest('operations', 'GET');
//        var_dump(UsefulData::getRequest());
//test.loc/fintest?accountFrom=24&accountTo=3&operations[]=2&&operations[]=2&&operations[]=2&&operations[]=5&&operations[]=2&&operations[]=3
        $transfer = new Transfer();
        $operations = (new Operation())->getList(array_unique($operationsIds));

        $operationsCounts = [];
        foreach ($operationsIds as $oId) {
            $operations[$oId]->cnt = isset($operations[$oId]->cnt)
            ? $operations[$oId]->cnt + 1 : 1;
        }
//        var_dump(__CLASS__);
//        var_dump($operations, $operationsCounts);
//        die;

        $transfer->createTransfer($fromId, $toId, $operations);
//        var_dump($transfer);
    }

}