<?php

namespace gries\NumberSystem;

/**
 * Class Number
 *
 * This is represents a number that can use any kind of number-system passed to it.
 *
 *
 * @package gries\NumberSystem
 */
class Number
{
    /**
     * @var NumberSystem
     */
    protected $numberSystem;

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @param              $value
     * @param NumberSystem $numberSystem
     * @param mixed         $delimiter
     */
    public function __construct($value, NumberSystem $numberSystem = null)
    {
        if (null === $numberSystem) {
            $numberSystem = new NumberSystem();
        }

        $this->numberSystem = $numberSystem;
        $this->value = $value;
    }

    /**
     * Get the value of this number.
     *
     * @return mixed
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * Convert this number into a other number-system.
     *
     * @param NumberSystem $newSystem
     *
     * @return Number
     */
    public function convert(NumberSystem $newSystem)
    {
        $newDigits = [];
        $decimalValue = gmp_init($this->decimalValue());

        do {
            $divisionResult = gmp_div_qr($decimalValue, $newSystem->getBase());
            $remainder = gmp_strval($divisionResult[1]);
            $decimalValue = $divisionResult[0];


            $newDigits[] = $newSystem->getSymbolForPosition($remainder);
        } while (gmp_strval($decimalValue) > 0);

        return $newSystem->buildNumber(array_reverse($newDigits));
    }

    /**
     * Get this number as a decimal string value.
     *
     * @return string
     */
    public function asDecimalString()
    {
        return $this->decimalValue();
    }


    /**
     * Compare two numbers.
     *
     * @param Number $comparedNumber
     *
     * @return bool
     */
    public function equals(Number $comparedNumber)
    {
        if ($this->value() !== $comparedNumber->value() ||
            !$this->getNumberSystem()->equals($comparedNumber->getNumberSystem()))  {
            return false;
        }

        return true;
    }

    /**
     * Get the NumberSystem of this Number.
     *
     * @return NumberSystem
     */
    public function getNumberSystem()
    {
        return $this->numberSystem;
    }

    /**
     * We use this to convert every number to decimal for calculations.
     */
    protected function decimalValue()
    {
        $base = $this->numberSystem->getBase();
        $result = 0;

        foreach (array_reverse($this->getDigits()) as $position => $value) {
            $numberSystemPosition = $this->numberSystem->getSymbolPosition($value);
            $result += $numberSystemPosition * pow($base, $position);
        }

        return $result;
    }

    /**
     * Add two number together.
     * The number-system of the result will be the one of the number
     * who's was the called object.
     *
     * @param Number|Number $addend
     *
     * @return Number
     */
    public function add(Number $addend)
    {
        $resultDecimalValue = $this->decimalValue() + $addend->decimalValue();

        $result = new Number($resultDecimalValue);

        return $result->convert($this->getNumberSystem());
    }

    /**
     * Subtract two numbers.
     * The number-system of the result will be the one of the number
     * who's was the called object.
     *
     * @param Number $subtractor
     *
     * @return Number
     */
    public function subtract(Number $subtractor)
    {
        $resultDecimalValue = $this->decimalValue() - $subtractor->decimalValue();

        $result = new Number($resultDecimalValue);

        return $result->convert($this->getNumberSystem());
    }

    /**
     * Multiply two numbers.
     * The number-system of the result will be the one of the number
     * who's was the called object.
     *
     * @param Number $multiplicator
     *
     * @return Number
     */
    public function multiply(Number $multiplicator)
    {
        $resultDecimalValue = $this->decimalValue() * $multiplicator->decimalValue();

        $result = new Number($resultDecimalValue);

        return $result->convert($this->getNumberSystem());
    }

    /**
     * Divide two numbers.
     * The number-system of the result will be the one of the number
     * who's was the called object.
     *
     * @param Number $multiplicator
     *
     * @return Number
     */
    public function divide(Number $multiplicator)
    {
        $resultDecimalValue = round($this->decimalValue() / $multiplicator->decimalValue(), 0);

        $result = new Number($resultDecimalValue);

        return $result->convert($this->getNumberSystem());
    }

    /**
     * Get a list of digits of this number.
     *
     * @return array
     */
    private function getDigits()
    {
        return $this->numberSystem->getDigits($this);
    }
}
