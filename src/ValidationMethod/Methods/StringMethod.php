<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod\Methods;

class StringMethod extends ValidationMethod
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

        $exceptionMessage = 'The '.join('.', $fieldToValidateParts).' field must be a string.';

        $isString = is_string($requestBodyField[$fieldToValidate]) === false;

        return $this->assertAndThrow($isString, $exceptionMessage);
    }
}
