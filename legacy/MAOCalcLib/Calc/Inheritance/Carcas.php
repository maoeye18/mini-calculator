<?php

namespace MAOCalcLib\Calc\Inheritance;

/**
 * Абстрактный класс, реализующий основные принципы работы будущих калькуляторов
 * Расширение функциональности предполагается через наследование и расширение
 * набора функций, путем реализации методов-функций и добавлением их вызова
 * 
 * @author Arkadiy
 */
abstract class Carcas extends \MAOCalcLib\Calc\ExpressionParsing {
    
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
        switch ($op) {
            default:
                $res = null;
                throw new \MAOCalcLib\Exception\UnknownOperation();
                break;
        }
        return (string)$res;
    }
}
