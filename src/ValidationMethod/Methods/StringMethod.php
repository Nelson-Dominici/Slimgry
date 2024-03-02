<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod\Methods;

class StringMethod extends ValidationMethod
{
    public function execute(array $requestBodyField, array $fieldToValidateParts, array $validationMethods): null
    {    
        if ($requestBodyField === []) {
            return null;
        }

        $fieldToValidate = end($fieldToValidateParts);

        $exceptionMessage = 'The '.join('.', $fieldToValidateParts).' field must be a string.';

        $isString = is_string($requestBodyField[$fieldToValidate]) === false;

        return $this->assertAndThrow($isString, $exceptionMessage);
    }
}
