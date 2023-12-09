<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod\Methods;

class TrimMethod extends ValidationMethod
{
    public function execute(array $requestBody, string $fieldToValidate): ?string
    {    
        if (
            empty($requestBody[$fieldToValidate]) || 
            !is_string($requestBody[$fieldToValidate])) 
        {
            return null;
        }

        return trim($requestBody[$fieldToValidate]);
    }
}
