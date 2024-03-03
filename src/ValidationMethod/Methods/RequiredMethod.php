<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod\Methods;

class RequiredMethod extends ValidationMethod
{
    public function execute(array $requestBodyField, array $fieldToValidateParts, array $validationMethods): null
    {
        $fieldToValidate = end($fieldToValidateParts);

        if (
            !array_key_exists($fieldToValidate, $requestBodyField) ||
            $requestBodyField[$fieldToValidate] === [] ||
            $requestBodyField[$fieldToValidate] === null ||
            (
                is_string($requestBodyField[$fieldToValidate]) && 
                trim($requestBodyField[$fieldToValidate]) === ''    
            )
        ) {
            $this->throwException('The '.join('.', $fieldToValidateParts).' field is required.');
        }

        return null;
    }
}