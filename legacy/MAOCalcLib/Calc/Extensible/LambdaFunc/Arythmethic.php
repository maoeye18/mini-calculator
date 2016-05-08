<?php

namespace MAOCalcLib\Calc\Extensible\LambdaFunc;

/**
 * Калькулятор с основными арифметическими операциями "+, -, *, /"
 *
 * @author Arkadiy
 */
class Arythmethic extends PlusMinus {
    
    public function __construct() {
        parent::__construct();
        $this->setFunc('*', function($a, $b) { return $a*$b; });
        $this->setFunc('/', function($a, $b) { 
            if ($b == 0) {
                throw new \MAOCalcLib\Exception\DivisionByZero();
            }
            return $a/$b; 
        });    
    }
}
