<?php
/**
 * Created by PhpStorm.
 * User: iskus
 * Date: 18.11.16
 * Time: 8:32
 */
namespace app\model;
use core\Model;

class Transfer extends Model
{
    private $id,
        $accountFromId,
        $accountToId,
        $amount;
    protected $operations = [];
    private $values = [];

    public function getAmount() {
        return $this->amount;
    }

    public function createTransfer($fromId, $toId, $operations) {
        $this->setAccountFromId($fromId);
        $this->setAccountToId($toId);
        $this->operations = $operations;
        $amount = 0;

        foreach ($this->operations as $key => $item) {
            $comission = new Comission('tax', $item->price);
            $item->price = $comission->getTotal();
            $operations[$item->id][] = $item->price;
            $amount += $item->price;
            $values[] = "(null, @TID, {$item->id}, " . count($operations[$item->id]) . ")";
        }
        $comission = new Comission('tax', $amount);
        $this->setAmount($comission->getTotal());
        $this->save();
    }

    public function setAccountFromId($accountFromId) {
        $this->accountFromId = (int)$accountFromId;
    }

    public function setAccountToId($accountToId) {
        $this->accountToId = (int)$accountToId;
    }

    public function setAmount($amount) {
        $this->amount = (float)$amount;
    }

    private function save() {
        $sql = "
        START TRANSACTION;
            SELECT @A:=(balance - {$this->getAmount()}) 
                FROM account WHERE id={$this->accountFromId};
            SELECT @B:=(balance + {$this->getAmount()}) 
                FROM account WHERE id={$this->accountToId};
            UPDATE account SET balance=@A WHERE id={$this->accountFromId};
            UPDATE account SET balance=@B WHERE id={$this->accountToId};
	        INSERT INTO transfer 
	            VALUE (null, {$this->accountFromId}, {$this->accountToId}, {$this->getAmount()});
	        SELECT @TID:=max(id) FROM transfer;
	        INSERT INTO transfer_operation VALUES " . implode(', ', $this->values) . ";
        COMMIT;
        ";
        return $this->Db->query($sql);
    }
}