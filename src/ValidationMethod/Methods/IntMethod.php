<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod\Methods;

class IntMethod extends ValidationMethod
{    
    public function execute(array $requestBodyField, array $fieldToValidateParts): null
    {
        $fieldToValidate = end($fieldToValidateParts);
      
        if ($requestBodyField === []) {
            return null;
        }

        $intValue = $requestBodyField[$fieldToValidate];

        $exceptionMessage = 'The '.join('.', $fieldToValidateParts).' field must be a valid integer.';

        $expression = is_int($intValue) === false;

        return $this->assertAndThrow($expression, $exceptionMessage);         
    }
}
