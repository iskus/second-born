<?php
/**
 * Created by PhpStorm.
 * User: iskus
 * Date: 18.11.16
 * Time: 8:57
 */
namespace app\model;

class ComissionTax extends Comission
{
    private $percent = 13,
            $total;

    public function getTotal() {
        $this->calculate();
        return (float)$this->total;
    }

    private function calculate() {
        $this->total = ($this->sum / 100) * $this->percent;
    }

}