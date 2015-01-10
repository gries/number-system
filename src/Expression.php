<?php

namespace gries\NumberSystem;

/**
 * Class Expression
 *
 * This represents a Mathematical Expression like: 1 + (2*3).
 *
 * @package gries\NumberSystem
 */
class Expression
{
    /**
     * @var string
     */
    private $expression;

    /**
     * @var NumberSystem
     */
    private $numberSystem;

    /**
     * @param              $expression
     * @param NumberSystem $system
     */
    public function __construct($expression, NumberSystem $system)
    {
        $this->expression = $expression;
        $this->numberSystem = $system;
    }

    /**
     * @return NumberSystem
     */
    public function getNumberSystem()
    {
        return $this->numberSystem;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->expression;
    }

    /**
     * @return string
     */
    public function value()
    {
        return $this->expression;
    }
}
