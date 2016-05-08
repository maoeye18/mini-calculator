<?php

namespace MAOCalcLib\Calc\Inheritance;

/**
 * Калькулятор с основными арифметическими операциями "+, -, *, /"
 *
 * @author Arkadiy
 */
class Arythmethic extends PlusMinus {

    /**
     * Умножение
     * @param int $a
     * @param int $b
     * @return int
     */
    protected function mult($a, $b) {
        return $a * $b;
    }

    /**
     * Деление
     * @param int $a
     * @param int $b
     * @return int or float
     * @throws \MAOCalcLib\Exception\DivisionByZero
     */
    protected function div($a, $b) {
        if ($b == 0) {
            throw new \MAOCalcLib\Exception\DivisionByZero();
        }
        return $a / $b;
    }
    
    protected function callFunc($a, $b, $op) {
        switch ($op) {
            case '*':
                $res = $this->mult($a, $b);
                break;
            case '/':
                $res = $this->div($a, $b);
                break;
            default:
                $res = parent::callFunc($a, $b, $op);
                break;
        }
        return $res;
    }
}
