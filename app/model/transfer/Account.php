<?php
/**
 * Created by PhpStorm.
 * User: iskus
 * Date: 18.11.16
 * Time: 8:32
 */
namespace app\model\transfer;

use core\Model;

use app\model\transfer\Operation;
use app\model\transfer\Transfer;
use app\model\transfer\TransferComission;

class Account extends Model
{
    private
        $id,
        $balance = 0;
    public $title;

    public function __construct($id = false)
    {
        parent::__construct();

        $this->id = (int)$id;
        return $this->getAccount();
    }

    private function getAccount()
    {
        $res = $this->id ? $this->getEntity($this->id) : $this;
        if (is_object($res)) {
            $this->balance = $res->balance;
        }
        return $this;
    }

    public function getBalance()
    {
        return $this->balance;
    }

    public function setBalance($amount)
    {
        $this->balance = (float)$amount;
    }

}