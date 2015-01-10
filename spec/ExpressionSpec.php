<?php

namespace spec\gries\NumberSystem;

use gries\NumberSystem\NumberSystem;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ExpressionSpec extends ObjectBehavior
{
    function let(NumberSystem $system)
    {
        $this->beConstructedWith('(1 + 2) * 3', $system);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('gries\NumberSystem\Expression');
    }

    function it_tells_us_its_numbersystem(NumberSystem $system)
    {
        $this->beConstructedWith('(1 + 2) * 3', $system);

        $this->getNumberSystem()->shouldReturn($system);
    }

    function it_can_be_converted_to_string()
    {
        $this->__toString()->shouldBe('(1 + 2) * 3');
    }

    function it_tells_us_its_string_value()
    {
        $this->value()->shouldBe('(1 + 2) * 3');
    }
}
