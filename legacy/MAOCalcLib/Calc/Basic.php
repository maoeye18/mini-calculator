<?php

namespace MAOCalcLib\Calc;

/**
 * Базовый абстрактный класс
 *
 * @author Arkadiy
 */
abstract class Basic {
    /**
     * Расчет выражения
     */
    abstract function calculate($expr);
}
