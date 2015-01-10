<?php

namespace gries\NumberSystem;

use gries\NumberSystem\Exception\NumberParseException;

/**
 * Class NumberSystem
 *
 * This class represents a number system.
 * A number-system consist of a number-index and a base.
 *
 * For example the decimal number-system is base 10 with symbols ranging from 0 to 10
 *
 * You can use this class to represent "abstract" number systems such as ["tree", "stone", "water"]
 * which is a system base 3.
 *
 *
 * @package gries\NumberSystem
 */
class NumberSystem
{
    /**
     * The symbols used by this system.
     *
     * @var array
     */
    protected $symbolIndex;

    /**
     * The numeric base of this system.
     *
     * @var int
     */
    protected $base;

    /**
     * Defines which string is used to split numbers.
     *
     * @var string
     */
    protected $delimiter;

    /**
     * @param array $symbolIndex
     * @param null  $delimiter
     */
    public function __construct(array $symbolIndex = null, $delimiter = null)
    {
        if (null === $symbolIndex) {
            $symbolIndex = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9' ]; // dont use range() here because we dont want integers
        }

        $this->delimiter = $delimiter;
        $this->symbolIndex = $symbolIndex;
        $this->base = count($symbolIndex);
    }

    /**
     * Get the symbol index of this system.
     *
     * @return array
     */
    public function getSymbolIndex()
    {
        return $this->symbolIndex;
    }

    /**
     * Get the base of this NumberSystem.
     *
     * @return int
     */
    public function getBase()
    {
        return $this->base;
    }

    /**
     * Get the delimiter used by this system.
     *
     * @return string
     */
    public function getDelimiter()
    {

    }

    /**
     * Compare two number systems.
     *
     * @param NumberSystem $comparedNumberSystem
     *
     * @return bool
     */
    public function equals(NumberSystem $comparedNumberSystem)
    {
        if ($this->getBase() !== $comparedNumberSystem->getBase() ||
            $this->getSymbolIndex() !== $comparedNumberSystem->getSymbolIndex()
        ) {
            return false;
        }

        return true;
    }

    /**
     * Get the position of a symbol in this system.
     *
     * @param $symbol
     *
     * @return int
     */
    public function getSymbolPosition($symbol)
    {
        return array_search($symbol,  $this->getSymbolIndex(), true);
    }

    /**
     * Get the symbol that lays on a given position of this system.
     *
     * @param $position
     *
     * @return mixed
     */
    public function getSymbolForPosition($position)
    {
        return $this->getSymbolIndex()[$position];
    }

    /**
     * Get all digits of a given number according to
     * this number-system.
     *
     * @param Number $number
     *
     * @return array
     */
    public function getDigits(Number $number)
    {
        if (null === $this->delimiter) {
            return str_split($number->value());
        }

        return explode($this->delimiter, $number->value());
    }

    /**
     * Build a number based on given digits.
     *
     * @param array $digits
     *
     * @return Number
     */
    public function buildNumber(array $digits)
    {
        $newNumberString = implode($this->delimiter, $digits);

        return new Number($newNumberString, $this);
    }

    /**
     * Check if a given symbol exists in this NumberSystem.
     *
     * @param $symbol
     *
     * @return bool
     */
    protected function containsSymbol($symbol)
    {
        return false !== $this->getSymbolPosition($symbol);
    }

    /**
     * Check if a string value is a valid number of this system.
     *
     * @param string $value
     * @throws NumberParseException
     *
     * @return bool
     */
    public function validateNumberValue($value)
    {
        if (null === $this->delimiter) {
            $parts = str_split($value);
        } else {
            $parts = explode($this->delimiter, $value);
        }

        foreach ($parts as $numberSymbol) {
            if (!$this->containsSymbol($numberSymbol)) {
                throw new NumberParseException($value, $numberSymbol);
            }
        }

        return true;
    }
}
