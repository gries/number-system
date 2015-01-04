<?php

namespace spec\gries\NumberSystem;

use gries\NumberSystem\Exception\NumberParseException;
use gries\NumberSystem\Number;
use gries\NumberSystem\NumberSystem;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NumberSystemSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('gries\NumberSystem\NumberSystem');
    }

    function it_uses_decimal_as_default_system()
    {
        $this->getSymbolIndex()->shouldReturn(['0', '1', '2', '3', '4', '5', '6', '7', '8', '9']);
    }

    function it_provides_all_available_symbols()
    {
        $symbols = [
            'a',
            'b',
            'c'
        ];

        $this->beConstructedWith($symbols);

        $this->getSymbolIndex()->shouldReturn($symbols);
    }

    function it_calculates_its_base_based_on_its_number_index()
    {
        $symbols = [
            'a',
            'b',
            'c'
        ];

        $this->beConstructedWith($symbols);

        $this->getBase()->shouldReturn(3);
    }

    function it_can_be_compared()
    {
        $symbols = [
            'a',
            'b',
            'c'
        ];

        $this->beConstructedWith($symbols);

        $diffrentSystem = new NumberSystem([1, 2, 3]);
        $sameSystem     = new NumberSystem($symbols);

        $this->equals($diffrentSystem)->shouldBe(false);
        $this->equals($sameSystem)->shouldBe(true);
    }

    function it_lets_us_retrieve_the_position_for_a_given_symbol()
    {
        $symbols = [
            'a',
            'b',
            'c'
        ];

        $this->beConstructedWith($symbols);

        $this->getSymbolPosition('b')->shouldBe(1);
    }

    function it_lets_us_retrieve_the_symbol_for_a_given_position()
    {
        $symbols = [
            'a',
            'b',
            'c'
        ];

        $this->beConstructedWith($symbols);

        $this->getSymbolForPosition(1)->shouldBe('b');
    }

    function it_parses_a_numbers_digits()
    {
        $symbols = [
            'a',
            'b',
            'c'
        ];

        $this->beConstructedWith($symbols);

        $number = new Number('aba', $this->getWrappedObject());
        $this->getDigits($number)->shouldBeLike(['a', 'b', 'a']);
    }

    function it_parses_a_numbers_digits_using_a_delimiter()
    {
        $symbols = [
            'a',
            'b',
            'c'
        ];

        $this->beConstructedWith($symbols, '-');

        $number = new Number('a-b-a', $this->getWrappedObject());
        $this->getDigits($number)->shouldBeLike(['a', 'b', 'a']);
    }

    function it_lets_us_build_a_number_based_on_a_list_of_digits()
    {
        $symbols = [
            'a',
            'b',
            'c'
        ];

        $this->beConstructedWith($symbols, '-');

        $this->buildNumber(['a', 'c', 'c'])->shouldHaveAValueOf('a-c-c');
        $this->buildNumber(['a', 'c', 'c'])->shouldHaveASystemLike($this->getWrappedObject());
    }

    function it_validates_a_number()
    {
        $symbols = [
            'a',
            'b',
            'c'
        ];

        $this->beConstructedWith($symbols, '-');
        $this->validateNumberValue('a-b')->shouldBe(true);
    }

    function it_throws_an_exception_during_validation_of_an_invalid_number()
    {
        $symbols = [
            'a',
            'b',
            'c'
        ];

        $this->beConstructedWith($symbols, '-');

        $expectedException = new NumberParseException('a-d', 'd');
        $this->shouldThrow($expectedException)->during('validateNumberValue', ['a-d']);
    }

    function getMatchers()
    {
        return [
            'matchANumberLike' => function (Number $actual, Number $expected) {
                if ($actual->equals($expected)) {
                    return true;
                }

                return false;
            },
            'haveAValueOf' => function (Number $actual, $expectedValue) {
                if ($actual->value() === $expectedValue) {
                    return true;
                }

                return false;
            },
            'haveASystemLike' => function (Number $actual, NumberSystem $expectedSystem) {
                if ($expectedSystem->equals($actual->getNumberSystem())) {
                    return true;
                }

                return false;
            },
        ];
    }
}
