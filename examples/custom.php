<?php

use gries\NumberSystem\Number;
use gries\NumberSystem\NumberSystem;

require_once __DIR__.'/../vendor/autoload.php';

$elementalSystem = new NumberSystem(['earth', 'fire', 'air', 'water'], '-');

// diffrent ways of creating a number
$number = new Number('fire-earth', $elementalSystem); // 4
$largerNumber = $elementalSystem->buildNumber(['fire', 'air', 'air']); // 26

// define your own number system and number
class YoloSystem extends NumberSystem
{
    public function __construct()
    {
        parent::__construct(['1337', 'yolo', 'swag'], '¿');
    }
}

class YoloNumber extends Number
{
    public function __construct($value)
    {
        parent::__construct($value, new YoloSystem());
    }
}

$foo = new YoloNumber('yolo¿swag¿yolo¿yolo¿yolo¿yolo¿swag');
echo $foo->asDecimalString(); // 1337

