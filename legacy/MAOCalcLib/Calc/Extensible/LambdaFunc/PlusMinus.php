<?php

namespace MAOCalcLib\Calc\Extensible\LambdaFunc;

/**
 * Простой калькулятор, реализующий сложение и вычитание
 *
 * @author Arkadiy
 */
class PlusMinus extends Carcas {
    
    public function __construct() {
        $this->setFunc('+', function($a, $b) { return $a+$b; });
        $this->setFunc('-', function($a, $b) { return $a-$b; });
    }
    
}
