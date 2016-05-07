<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MAOCalcLib\Calc;

/**
 * Description of ExprParsing
 *
 * @author Arkadiy
 */
abstract class ExpressionParsing extends Basic{
    
    /**
     * Ожидаемое расположение функции в выражении
     * @var string 
     */
    protected $functionPosition = 'any';
    
    /**
     * Поддерживаемые варианты расположения функции в выражении
     * infix - между операндами, prefix - перед операндами,
     * postfix - после операндов, any - обработать все варианты в порядке описания
     * @var array 
     */
    protected $posibleFunctionPositions = array('infx', 'prefix', 'postfix', 'any');
    
    /**
     * Шаблоны регулярных выражений для парсинга выражения на операнды и операцию
     * @var array
     */
    protected $exprPatterns = array('operand' => "-?\d+", 'operation' => "[^0-9,]+");
    
    /**
     * Указать ожидаемое положение функции
     * @param string $newPosition
     */
    public function setFunctionPosition($newPosition) {
        if (in_array($newPosition, $this->getPosibleFunctionPositions())) {
            $this->functionPosition = $newPosition;
            return true;
        }
        return false;
    }
    
    /**
     * Получить ожидаемую позицию функции
     * @return string
     */
    public function getFunctionPosition() {
        return $this->functionPosition;
    }
    
    /**
     * Получить массив поддерживаемых позиций функции
     * @return type
     */
    public function getPosibleFunctionPositions() {
        return $this->posibleFunctionPositions;
    }
    
    /**
     * Вызов парсинга
     * @param string $expr - выражение
     * @return type
     * @throws \MAOCalcLib\Exception
     */
    protected function callParse($expr) {
        $funcPos = $this->getFunctionPosition();
        $expr = str_replace(array(' ', "\t"), array('' , ''), $expr);
        switch($funcPos) {
            case 'infix':
            case 'prefix':
            case 'postfix':
                $this->parse($expr, $funcPos);
                break;
            case 'any':
                try {
                    return $this->parse($expr, 'infix');    
                } catch (\Exception $ex) {}
                try {
                    return $this->parse($expr, 'prefix');
                } catch (\Exception $ex) {}
                try {
                    return $this->parse($expr, 'postfix');
                } catch (\Exception $ex) {}
                throw new \MAOCalcLib\Exception($this->prepareParseExceptionMessage($funcPos));
                break;
        }
    }
    
    /**
     * Парсинг выражения 
     * 
     * @param string $expr
     * @param string $funcPos
     */
    protected function parse($expr, $funcPos) {
        $matches = array();
        //echo $this->prepareExpressionPattern($funcPos);
        $res = preg_match($this->prepareExpressionPattern($funcPos), $expr, $matches);
        if ($res === 0) {
            throw new \MAOCalcLib\Exception\CannotParse($this->prepareParseExceptionMessage($funcPos));
        } elseif ($res === false) {
            throw new \MAOCalcLib\Exception\CannotParse('Ошибка регулярного выражения, обратитесь к разработчикам');
        } else {     
            $operIndex = $this->prepareOperationIndex($funcPos);
            $ret = array();
            array_shift($matches);
            $ret['op'] = $matches[$operIndex];
            unset($matches[$operIndex]);
            $matches = array_values($matches);
            $ret['a'] = $matches[0];
            $ret['b'] = $matches[1];
            return $ret;
        }
    }
    
    protected function prepareExpressionPattern($funcPos) {
        $pattern = array("/^(", null, ")(", null, ")(", null, ")$/U");
        for ($i = 1; $i <=5; $i += 2) {
            $pattern[$i] = $this->exprPatterns['operand'];
        }
        $operIndex = $this->prepareOperationIndex($funcPos);
        $pattern[1 + $operIndex*2] = $this->exprPatterns['operation'];
        if     ($operIndex == 0) { $pattern[4] = "),("; }
        elseif ($operIndex == 2) { $pattern[2] = "),("; }
        return implode("", $pattern);
    }
    
    
    protected function prepareOperationIndex($funcPos) {
        $indexes = array('infix' => 1,
                         'prefix' => 0,
                         'postfix' => 2);
        return $indexes[$funcPos];
        
    }
    
    protected function prepareParseExceptionMessage($funcPos) {
        $messages = array('infix'  => 'Невозможно разобрать выражение, возможно оно не в инфиксной форме',
                         'prefix'  => 'Невозможно разобрать выражение, возможно оно не в префиксной форме',
                         'postfix' => 'Невозможно разобрать выражение, возможно оно не в постфиксной форме',
                         'any'     => 'Невозможно разобрать выражение');
        return $messages[$funcPos];
    }
    
    abstract protected function callFunc($a, $b, $op);
    
    /**
     * Расчет выражения
     * 
     * @param string $expr Выражение для расчета
     * @return string Результат расчета
     */
    public function calculate($expr) {
        $parsedExpr = $this->callParse($expr);
        
        $a  = $parsedExpr['a'];
        $b  = $parsedExpr['b'];
        $op = $parsedExpr['op'];
         
        //extract($parsedExpr);
        $res = $this->callFunc((integer)$a, (integer)$b, $op);
        
        return $res;
    }
}
