<?php
/**
 * Created by PhpStorm.
 * User: iskus
 * Date: 18.11.16
 * Time: 8:32
 */
namespace app\model\transfer;

use core\Model;

class Transfer extends Model
{
    protected $operations = [];
    private
        $id,
        $accountFromId,
        $accountToId,
        $amount,
        $fbalance,
        $tbalance;
    private $values = [];

    public function createTransfer($fromId, $toId, $operations)
    {
        $this->setAccountFromId($fromId);
        $this->setAccountToId($toId);
        $this->operations = $operations;
        $amount = 0;


        foreach ($this->operations as $key => $item) {
            $comission = new TransferComission('tax', $item->price);
            $item->price = $comission->getTotal();
            $amount += $item->price / 100;
            $this->values[] = "(null, @TID, {$item->id}, {$item->cnt})";
        }
        $comission = new TransferComission('tax', $amount);
        $this->setAmount(round($comission->getTotal(), 2));

        $from = new Account($this->getAccountFromId());
        $to = new Account($this->getAccountFromId());
//        var_dump($from, $from->getBalance(), $this->getAmount());
        $from->setBalance($this->fbalance = $to->getBalance() - $this->amount);
        $to->setBalance($this->tbalance = $to->getBalance() + $this->amount);
        if ($from->getBalance() < $this->getAmount())
            throw new \Exception('Low balance, you need deposit! FROM ' . __CLASS__);

        $this->save();
    }

    public function setAccountFromId($accountFromId)
    {
        $this->accountFromId = (int)$accountFromId;
    }

    public function setAccountToId($accountToId)
    {
        $this->accountToId = (int)$accountToId;
    }

    public function setAmount($amount)
    {
        $this->amount = (float)$amount;
    }

    public function getAccountFromId()
    {
        return $this->accountFromId;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    private function save()
    {


        $sql = "
        SET autocommit=0;
        START TRANSACTION;
        
#        SELECT @A:=(balance - {$this->getAmount()})
#                FROM account WHERE id={$this->accountFromId};
#        SELECT @B:=(balance + {$this->getAmount()})
#            FROM account WHERE id={$this->accountToId};
                
                
                
                
                
            UPDATE account SET balance={$this->fbalance} WHERE id={$this->accountFromId};
            UPDATE account SET balance={$this->tbalance} WHERE id={$this->accountToId};
	        INSERT INTO transfer 
	            VALUE (null, {$this->accountFromId}, {$this->accountToId}, {$this->getAmount()});
	        SELECT @TID:=max(id) FROM transfer;
	        INSERT INTO transfer_operation VALUES " . implode(', ', $this->values) . ";
        COMMIT;
        ";
//        var_dump($sql);
        return $this->Db->query($sql);
    }

    public function getAccountToId()
    {
        return $this->accountToId;
    }
}