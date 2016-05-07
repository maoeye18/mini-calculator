<?php

namespace MAOCalcLib\Calc\Inheritance;

/**
 * Простой калькулятор, реализующий сложение и вычитание
 *
 * @author Arkadiy
 */
class PlusMinus extends Carcas {
    
    /**
     * Сложение
     * @param int $a
     * @param int $b
     * @return int
     */
    protected function sum($a, $b) {
        return $a + $b;
    }
    
    /**
     * Вычитание
     * @param int $a
     * @param int $b
     * @return int
     */
    protected function diff($a, $b) {
        return $a - $b;
    }
    
    protected function callFunc($a, $b, $op) {
        switch ($op) {
            case '+':
                $res = $this->Sum($a, $b);
                break;
            case '-':
                $res = $this->diff($a, $b);
                break;
            default:
                $res = parent::callFunc($a, $b, $op);
                break;
        }
        return $res;
    }
}
