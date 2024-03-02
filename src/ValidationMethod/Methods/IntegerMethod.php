<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod\Methods;

class IntegerMethod extends ValidationMethod
{    
    public function execute(array $requestBodyField, array $fieldToValidateParts, array $validationMethods): null
    {
        $fieldToValidate = end($fieldToValidateParts);
      
        if (
            $requestBodyField === [] ||
            (
                in_array('nullable', $validationMethods) && 
                $requestBodyField[$fieldToValidate] === null
            )
        ) {
            return null;
        }

        $intValue = $requestBodyField[$fieldToValidate];

        $exceptionMessage = 'The '.join('.', $fieldToValidateParts).' field must be a valid integer.';

        $expression = is_int($intValue) === false;

        return $this->assertAndThrow($expression, $exceptionMessage);         
    }
}
