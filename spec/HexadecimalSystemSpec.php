<?php

namespace spec\gries\NumberSystem;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class HexadecimalSystemSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('gries\NumberSystem\HexadecimalSystem');
    }

    function its_base_is_two()
    {
        $this->getBase()->shouldBe(16);
    }

    function its_symbol_index_uses_binary_symbols()
    {
        $this->getSymbolIndex()->shouldBeLike(['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D','E','F']);
    }
}
