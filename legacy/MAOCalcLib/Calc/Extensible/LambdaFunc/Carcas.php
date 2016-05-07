<?php

namespace MAOCalcLib\Calc\Extensible\LambdaFunc;

/**
 * Абстрактный класс, реализующий основные принципы работы будущих калькуляторов
 * Расширение предполагается наполнением пула функций объекта в форме анонимных
 * функций PHP 
 * 
 * @author Arkadiy
 */
class Carcas extends \MAOCalcLib\Calc\ExpressionParsing {
    
    protected $funcs = array();

    /**
     * Добавить функцию в калькулятор
     * Связывает символическое представление функции и лямбду, высчитывающую результат
     * 
     * @param string $symbols - подстрока выражения, соответствующая функции
     * @param \Closure $func - код функции
     */
    public function setFunc($symbols, $func) {
        if (is_object($func) && ($func instanceof \Closure)     //проерка, что работаем с анонимной функцией
                             && is_string($symbols)
                             ) { 
            $this->funcs[$symbols] = $func;
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Вызов функции в зависимости от текстового представления в выражении
     * 
     * @param int $a Левый операнд
     * @param int $b Правый операнд
     * @param string $op Операция
     * @return string Результат выполнения функции
     * @throws \MAOCalcLib\Exception\UnknownOperation
     */
    protected function callFunc($a, $b, $op) {
        if (isset($this->funcs[$op])) {
            $res = $this->funcs[$op]($a, $b);
        } else {
            throw new \MAOCalcLib\Exception\UnknownOperation();
        }
        return (string)$res;
    }
}
