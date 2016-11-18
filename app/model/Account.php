<?php
/**
 * Created by PhpStorm.
 * User: iskus
 * Date: 18.11.16
 * Time: 8:32
 */
namespace app\model;

use core\Model;

class Account extends Model
{
    private $id,
            $title,
            $balance;

    public function __construct($id = false)
    {
        parent::__construct();

        $this->id = (int)$id;
        return $this->getAccount();
    }

    /**
     * @return mixed
     */
    public function getBalance()
    {
        return $this->balance;
    }

    public function setBalance()
    {

    }

    private function getAccount() {
        return $this->id ? $this->getEntity($this->id) : $this;
    }

}