<?php

namespace MAOCalcLib\Exception;

/**
 * Ошибка деления на ноль
 *
 * @author Arkadiy
 */
class DivisionByZero extends \Exception {
    protected $message = 'Деление на ноль невозможно.';
}
