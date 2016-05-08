<?php

//скрипт отдающий результат расчета

require_once('loader.php');

//header('Content-Type: application/x-javascript; charset=utf8');  

$answer = array('expression' => '',
                'result' => 'calculated',
                'message' => 'Выражение успешно вычислено',
                'answer' => '');

function sendAnswer($answer) {
    $resForm = filter_input(INPUT_GET, 'resform', FILTER_SANITIZE_SPECIAL_CHARS);
    $callback = filter_input(INPUT_GET, 'callback', FILTER_SANITIZE_SPECIAL_CHARS);
    if (isset($resForm) && $resForm === 'jsonp' && isset($callback)) {
        $res = json_encode($answer);
        $res = "{$callback}({$res})";
        echo $res;
    } else {
        echo json_encode($answer);
    }
    die();
}

$expr = filter_input(INPUT_GET, 'expression', FILTER_SANITIZE_SPECIAL_CHARS);

if (!isset($expr)) {
    $answer['result'] = 'error';
    $answer['message'] = 'К сожалению, выражение не было получено от клиента, '
                       . 'обратитесь за помощью к разработчикам калькулятора';
    sendAnswer($answer);
}

if ($expr === false) {
    $answer['result'] = 'error';
    $answer['message'] = 'К сожалению, полученное выражение невозможно обработать, '
                       . 'обратитесь за помощью к разработчикам калькулятора';
    sendAnswer($answer);
}

$answer['expression'] = $expr;

switch (rand(0,1)) {
    case 0:
        $myCalc = new \MAOCalcLib\Calc\Inheritance\Arythmethic();
        break;
    case 1:
        $myCalc = new \MAOCalcLib\Calc\Extensible\LambdaFunc\Arythmethic();
        break;
}



try {
    $r = $myCalc->calculate($expr);
} catch (Exception $e) {
    $answer['result'] = 'error';
    $answer['message'] = $e->getMessage();
    sendAnswer($answer);
}

$answer['answer'] = $r;
sendAnswer($answer);
