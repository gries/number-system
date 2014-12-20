<?php

namespace gries\NumberSystem;

/**
 * Class HexadecimalSystem
 *
 * @package gries\NumberSystem
 */
class HexadecimalSystem extends NumberSystem
{
    public function __construct()
    {
        return parent::__construct(['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D','E','F']);
    }
}
