<?php

function maoAutoLoad($className) {
    require_once(str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php');
}

spl_autoload_register('maoAutoLoad');

