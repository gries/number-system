<?php

namespace spec\gries\NumberSystem;

use gries\NumberSystem\Number;
use gries\NumberSystem\NumberSystem;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NumberSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(1);
        $this->shouldHaveType('gries\NumberSystem\Number');
    }

    function its_value_can_be_retrieved()
    {
        $elementalSystem = new NumberSystem(['earth', 'fire', 'air', 'water'], '-');

        $this->beConstructedWith('fire-air-water', $elementalSystem, '-');
        $this->value()->shouldReturn('fire-air-water');
    }

    function it_can_be_compared_with_equal_number()
    {
        $elementalSystem = new NumberSystem(['earth', 'fire', 'air', 'water'], '-');

        $this->beConstructedWith('earth', $elementalSystem);

        $sameNumber = new Number('earth', $elementalSystem);

        $this->equals($sameNumber)->shouldBe(true);
    }

    function it_can_be_compared_with_a_diffrent_value()
    {
        $elementalSystem = new NumberSystem(['earth', 'fire', 'air', 'water'], '-');

        $this->beConstructedWith('earth', $elementalSystem);

        $numberWithDiffrentValue = new Number('H', $elementalSystem);

        $this->equals($numberWithDiffrentValue)->shouldBe(false);
    }

    function it_can_be_compared_with_a_diffrent_system()
    {
        $elementalSystem = new NumberSystem(['earth', 'fire', 'air', 'water'], '-');
        $otherElementalSystem = new NumberSystem(['H', 'O', 'C', 'earth']);

        $this->beConstructedWith('earth', $elementalSystem);

        $numberWithDiffrentSystem = new Number('earth', $otherElementalSystem);
        $this->equals($numberWithDiffrentSystem)->shouldBe(false);
    }

    function it_can_be_converted_into_another_system()
    {
        $elementalSystem = new NumberSystem(['earth', 'fire', 'air', 'water'], '-');
        $this->beConstructedWith('fire-fire-earth-air', $elementalSystem, '-');

        $base6 = new NumberSystem([0, 1, 2, 3, 4, 5]);
        $expectedNumber = new Number('214', $base6);

        $this->convert($base6)->shouldMatchANumberLike($expectedNumber);
    }

    function it_can_be_converted_into_another_system_with_a_delimiter()
    {
        $elementalSystem = new NumberSystem(['earth', 'fire', 'air', 'water'], '-');
        $base6 = new NumberSystem(['0', '1', '2', '3', '4', '5']);

        $this->beConstructedWith('214', $base6);

        $this->convert($elementalSystem)->shouldHaveAValueOf('fire-fire-earth-air');
        $this->convert($elementalSystem)->shouldHaveASystemLike($elementalSystem);
    }

    function it_can_convert_using_large_numbers()
    {
        // hexa
        $hexaSystem = new NumberSystem(array_merge(range(0,9), range('A', 'F')));
        $this->beConstructedWith('ACABACAB', $hexaSystem);

        $binary = new NumberSystem([0, 1]);
        $expectedNumber = new Number('10101100101010111010110010101011', $binary);
        $this->convert($binary)->shouldMatchANumberLike($expectedNumber);
    }

    function it_can_be_printed_as_decimal()
    {
        $elementalSystem = new NumberSystem(['earth', 'fire', 'air', 'water'], '-');

        $this->beConstructedWith('fire-air-water', $elementalSystem, '-');
        $this->asDecimalString()->shouldReturn(27);
    }

    function it_can_be_printed_as_decimal_if_its_a_decimal_number()
    {
        $decimalSystem = new NumberSystem();

        $this->beConstructedWith(2, $decimalSystem);
        $this->asDecimalString()->shouldReturn(2);
    }

    function it_can_be_added_with_another_number()
    {
        $elementalSystem = new NumberSystem(['earth', 'fire', 'air', 'water'], '-');
        $this->beConstructedWith('fire', $elementalSystem);

        $addend = new Number('fire', $elementalSystem);

        $this->add($addend)->shouldHaveAValueOf('air');
        $this->add($addend)->shouldHaveASystemLike($elementalSystem);
    }

    function it_can_be_added_with_a_number_with_a_diffrent_number_system()
    {
        $elementalSystem = new NumberSystem(['earth', 'fire', 'air', 'water'], '-');
        $this->beConstructedWith('fire', $elementalSystem);

        $addendDecimal = new Number(10); // decimal

        $this->add($addendDecimal)->shouldHaveAValueOf('air-water');
        $this->add($addendDecimal)->shouldHaveASystemLike($elementalSystem);
    }

    function it_can_be_subtracted_with_another_number()
    {
        $elementalSystem = new NumberSystem(['earth', 'fire', 'air', 'water'], '-');
        $this->beConstructedWith('water', $elementalSystem);

        $subtractor = new Number('fire', $elementalSystem);

        $this->subtract($subtractor)->shouldHaveAValueOf('air');
        $this->subtract($subtractor)->shouldHaveASystemLike($elementalSystem);
    }

    function it_can_be_subtracted_with_another_number_with_a_diffrent_number_system()
    {
        $elementalSystem = new NumberSystem(['earth', 'fire', 'air', 'water'], '-');
        $this->beConstructedWith('water-air', $elementalSystem);

        $subtractorDecimal = new Number(10); // decimal

        $this->subtract($subtractorDecimal)->shouldHaveAValueOf('fire-earth');
        $this->subtract($subtractorDecimal)->shouldHaveASystemLike($elementalSystem);
    }

    function it_can_be_multiplicated_with_another_number()
    {
        $elementalSystem = new NumberSystem(['earth', 'fire', 'air', 'water'], '-');
        $this->beConstructedWith('air', $elementalSystem);

        $multiplicator = new Number('water', $elementalSystem);

        $this->multiply($multiplicator)->shouldHaveAValueOf('fire-air');
        $this->multiply($multiplicator)->shouldHaveASystemLike($elementalSystem);
    }

    function it_can_be_multiplicated_with_another_number_with_a_diffrent_number_system()
    {
        $elementalSystem = new NumberSystem(['earth', 'fire', 'air', 'water'], '-');
        $this->beConstructedWith('air', $elementalSystem);

        $multiplicatorDecimal = new Number(3);

        $this->multiply($multiplicatorDecimal)->shouldHaveAValueOf('fire-air');
        $this->multiply($multiplicatorDecimal)->shouldHaveASystemLike($elementalSystem);
    }

    function it_can_be_devided_with_another_number_with_a_diffrent_number_system()
    {
        $elementalSystem = new NumberSystem(['earth', 'fire', 'air', 'water'], '-');
        $this->beConstructedWith('water', $elementalSystem);

        $dividerDecimal = new Number(2);

        $this->divide($dividerDecimal)->shouldHaveAValueOf('air');
        $this->divide($dividerDecimal)->shouldHaveASystemLike($elementalSystem);
    }

    function it_can_be_devided_with_another_number()
    {
        $elementalSystem = new NumberSystem(['earth', 'fire', 'air', 'water'], '-');
        $this->beConstructedWith('water', $elementalSystem);

        $divider = new Number('air', $elementalSystem);

        $this->divide($divider)->shouldHaveAValueOf('air');
        $this->divide($divider)->shouldHaveASystemLike($elementalSystem);
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
