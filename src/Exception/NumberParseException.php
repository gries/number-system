<?php
namespace gries\NumberSystem\Exception;

/**
 * Class NumberParseException
 *
 * Indicates that a given number could not be parsed.
 *
 */
class NumberParseException extends NumberSystemException
{
    public function __construct($invalidValue, $invalidSymbol)
    {
        parent::__construct(sprintf('Could not parse the given number value: "%s". The symbol "%s" is not recognised', $invalidValue, $invalidSymbol));
    }
}
