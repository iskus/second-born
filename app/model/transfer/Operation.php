<?php

/**
 * Created by PhpStorm.
 * User: iskus
 * Date: 18.11.16
 * Time: 8:32
 */
namespace app\model\transfer;

use core\Model;
use app\model\transfer\Account;
use app\model\transfer\Transfer;
use app\model\transfer\TransferComission;

class Operation extends Model
{
    public
        $id,
        $title,
        $price;

    public function getList($ids)
    {
//        var_dump($ids);
        if (!$ids) return $this->getEntitys([]);
        $ids = is_array($ids) ? $ids : [$ids];
//        array_walk($ids, 'intval');
       return $this->getEntitys(["id" => $ids]);
    }


}