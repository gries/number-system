<?php

namespace spec\gries\NumberSystem;

use gries\NumberSystem\BinarySystem;
use gries\NumberSystem\Expression;
use gries\NumberSystem\NumberSystem;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ExpressionConverterSpec extends ObjectBehavior
{
    protected $binary;

    protected $decimal;

    function let()
    {
        $this->binary = new BinarySystem();
        $this->decimal = new NumberSystem();
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('gries\NumberSystem\ExpressionConverter');
    }

    function it_converts_a_simple_expression()
    {
        $expression = new Expression('2 + 3', $this->decimal);

        $this->convert($expression, $this->binary)->shouldHaveAValueOf('10 + 11');
        $this->convert($expression, $this->binary)->shouldHaveASystemOf($this->binary);
    }

    function it_converts_complex_expressions()
    {
        $expression = new Expression('2 + (3*4) / 7', $this->decimal);

        $this->convert($expression, $this->binary)->shouldHaveAValueOf('10 + (11*100) / 111');
        $this->convert($expression, $this->binary)->shouldHaveASystemOf($this->binary);
    }

    function it_converts_expressions_containing_mathematical_functions()
    {
        $expression = new Expression('2 + sin(3)-4', $this->decimal);

        $this->convert($expression, $this->binary)->shouldHaveAValueOf('10 + sin(11)-100');
        $this->convert($expression, $this->binary)->shouldHaveASystemOf($this->binary);
    }

    function getMatchers()
    {
        return [

            'haveAValueOf' => function (Expression $actual, $expectedValue) {
                if ($actual->value() === $expectedValue) {
                    return true;
                }
                return false;
            },
            'haveASystemOf' => function (Expression $actual, NumberSystem $expectedSystem) {
                if ($expectedSystem->equals($actual->getNumberSystem())) {
                    return true;
                }

                return false;
            },
        ];
    }
}
