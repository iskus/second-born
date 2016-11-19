<?php
/**
 * Created by PhpStorm.
 * User: iskus
 * Date: 18.11.16
 * Time: 8:57
 */
namespace app\model\transfer;

class TransferComission //extends Model
{
    protected $sum;
    private $total;
    public $type;

    public function __construct($type, $sum)
    {
        $this->type = ucfirst($type);
        $method = "calc" . $this->type;
        $this->sum = $sum;
        $this->{$method}();
    }

    private function calcTax()
    {

        $this->total = $this->sum - ($this->sum / 100) * 13;
    }

    public function getTotal()
    {
        return $this->total;
    }

}