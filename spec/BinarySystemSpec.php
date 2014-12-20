<?php

namespace spec\gries\NumberSystem;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BinarySystemSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('gries\NumberSystem\BinarySystem');
    }

    function its_base_is_two()
    {
        $this->getBase()->shouldBe(2);
    }

    function its_symbol_index_uses_binary_symbols()
    {
        $this->getSymbolIndex()->shouldBeLike(['0', '1']);
    }
}
