<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod\Methods;

class NumericMethod extends ValidationMethod
{    
    public function execute(array $requestBody): null
    {
        if (!array_key_exists($this->fieldToValidate, $requestBody)) {
            return null;
        }

        $numericValue = $requestBody[$this->fieldToValidate];

        $exceptionMessage = "The {$this->fieldToValidate} field does not have a numeric value.";

        $expression = is_numeric($numericValue) === false;

        return $this->assertAndThrow($expression, $exceptionMessage);     
    }
}
