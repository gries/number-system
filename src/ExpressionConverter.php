<?php

namespace gries\NumberSystem;

use gries\NumberSystem\Exception\NumberParseException;

/**
 * Class ExpressionConverter
 *
 * Use this class to convert expression from one NumberSystem to another.
 * Example:
 *  "2 + 3" => "10 + 11" binary to decimal
 *
 * @package gries\NumberSystem
 */
class ExpressionConverter
{

    /**
     * Convert expression from one NumberSystem to another
     *
     * @param Expression   $expression
     * @param NumberSystem $targetSystem
     *
     * @return Expression
     */
    public function convert(Expression $expression, NumberSystem $targetSystem)
    {
        $parsingResult   = $expression->value();
        $expressionParts = $this->getExpressionParts($expression);

        foreach ($expressionParts as $part) {
            $parsedPart = $this->parseExpressionPart($part, $expression->getNumberSystem(), $targetSystem);

            if ($parsedPart !== $part) {
                $parsingResult = preg_replace('/'.$part.'/', $parsedPart, $parsingResult, 1);
            }
        }

        return new Expression($parsingResult, $targetSystem);
    }

    /**
     * Parse the part of an expression.
     *
     * @param $part
     *
     * @return Number
     */
    protected function parseExpressionPart($part, NumberSystem $sourceSystem, NumberSystem $targetSystem)
    {
        try {
            // if it is a valid number of the source-system convert it
            $sourceNumber = new Number($part, $sourceSystem);

            return $sourceNumber->convert($targetSystem)->value();
        } catch (NumberParseException $e) {
            return $part;
        }
    }

    /**
     * @param Expression $expression
     *
     * @return array
     */
    public function getExpressionParts(Expression $expression)
    {
        $cleanedExpression = preg_replace('/[()*\-+\/]/', ' ', $expression->value());
        $expressionParts   = explode(' ', $cleanedExpression);

        return$expressionParts;
    }
}
