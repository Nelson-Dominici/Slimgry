<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod\Methods;

class TrimMethod extends ValidationMethod
{
    public function execute(array $requestBody, array $validatedRequestBody): ?array
    {
        if (
            empty($validatedRequestBody[$this->fieldToValidate]) || 
            !is_string($validatedRequestBody[$this->fieldToValidate])
        ) {
            return null;
        }
        
        $validatedRequestBody[$this->fieldToValidate] = trim($validatedRequestBody[$this->fieldToValidate]);
        
        return $validatedRequestBody;
    }
}
