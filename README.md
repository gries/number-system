Number-System
========

This PHP-Library can be used to make simple calculations with dynamic number-systems.

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/53d14756-ee29-4339-9956-d2f0e1b2e9b7/big.png)](https://insight.sensiolabs.com/projects/49b6b2b4-06a6-40c3-af3f-a921e790e0c6)

[![Build Status](https://travis-ci.org/gries/number-system.png?branch=master)](https://travis-ci.org/gries/number-system)

Installation
------------

Number-System can be installed via. Composer:

    composer require "gries/number-system"

Usage
-----------

Simple
-----------
```php
use gries\NumberSystem\HexadecimalSystem;
use gries\NumberSystem\Number;

require_once __DIR__.'/../vendor/autoload.php';

$number = new Number(15); // the default system is decimal
$hexNumber = new Number('FF', new HexadecimalSystem());

echo $number->add($hexNumber)->value(); // 270 (15 + 255)
echo $hexNumber->add($number)->value(); // 10E (F + FF)
```

Customer Number System
----------------------
```php
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
```

Current limitations aka todo's
-----------------------------
* No support for negative numbers
* No support of floating point numbers
* Division always rounds to 0 because ... no floating point number support ;)

Running the tests
-----------------
    vendor/bin/phpspec run

Contribute!
-----------
Feel free to give me feedback/feature-request/bug-reports via. github issues.
Or just send me a pull-request :)


Author
------

- [Christoph Rosse](http://twitter.com/griesx)

License
-------

For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
