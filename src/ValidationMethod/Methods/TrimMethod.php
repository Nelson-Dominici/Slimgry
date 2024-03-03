<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod\Methods;

class TrimMethod extends ValidationMethod
{
    public function execute(array $requestBodyField, array $fieldToValidateParts, array $validationMethods): ?array
    {
        $fieldToValidate = end($fieldToValidateParts);
       
        if (
            $requestBodyField === [] || 
            !$requestBodyField[$fieldToValidate] || 
            !is_string($requestBodyField[$fieldToValidate])
        ) {
            return null;
        }

        return [trim($requestBodyField[$fieldToValidate])];
    }
}
