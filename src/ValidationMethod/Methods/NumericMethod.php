<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod\Methods;

class NumericMethod extends ValidationMethod
{    
    public function execute(array $requestBodyField, array $fieldToValidateParts, array $validationMethods): null
    {
        $fieldToValidate = end($fieldToValidateParts);
  
        if ($requestBodyField === []) {
            return null;
        }

        $numericValue = $requestBodyField[$fieldToValidate];

        $exceptionMessage = 'The '.join('.', $fieldToValidateParts).' field must have a numeric value.';

        $expression = is_numeric($numericValue) === false;

        return $this->assertAndThrow($expression, $exceptionMessage);     
    }
}
