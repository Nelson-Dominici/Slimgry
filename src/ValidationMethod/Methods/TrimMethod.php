<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod\Methods;

class TrimMethod extends ValidationMethod
{
    public function execute(string $fieldToValidate, array $requestBody, array $validatedRequestBody): ?array
    {
        if (
            empty($validatedRequestBody[$fieldToValidate]) || 
            !is_string($validatedRequestBody[$fieldToValidate])
        ) {
            return null;
        }
        
        $validatedRequestBody[$fieldToValidate] = trim($validatedRequestBody[$fieldToValidate]);
        
        return $validatedRequestBody;
    }
}
