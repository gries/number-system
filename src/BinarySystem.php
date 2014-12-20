<?php

namespace gries\NumberSystem;

/**
 * Class BinarySystem
 *
 * @package gries\NumberSystem
 */
class BinarySystem extends NumberSystem
{
    public function __construct()
    {
        parent::__construct(['0', '1']);
    }
}
