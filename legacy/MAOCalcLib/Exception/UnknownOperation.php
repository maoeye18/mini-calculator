<?php

namespace MAOCalcLib\Exception;

/**
 * Ошибка - неизвестная операция
 *
 * @author Arkadiy
 */
class UnknownOperation extends \Exception {
    protected $message = 'К сожалению, выражение невозможно вычислить, т.к. была запрошена неизвестная операция';
}
