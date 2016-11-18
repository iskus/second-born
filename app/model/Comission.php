<?php
/**
 * Created by PhpStorm.
 * User: iskus
 * Date: 18.11.16
 * Time: 8:57
 */
namespace app\model;

use core\Model;

class Comission extends Model
{
    private $comission;
    private $type;
    protected $sum;

    public function __construct($type, $sum)
    {
        $this->type = ucfirst($type);
        $childName = "Comission{$this->type}";
        $this->comission = new $childName();
        $this->sum = $sum;
        parent::__construct();
    }

    public function getTotal()
    {
        return $this->comission->getTotal();
    }

}