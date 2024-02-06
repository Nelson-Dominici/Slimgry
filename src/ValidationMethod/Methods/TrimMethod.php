<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod\Methods;

class TrimMethod extends ValidationMethod
{
    public function execute(array $requestBody): ?array
    {
        if (
            !array_key_exists($this->fieldToValidate, $requestBody) || 
            !$requestBody[$this->fieldToValidate] || 
            !is_string($requestBody[$this->fieldToValidate])
        ) {
            return null;
        }
        
        $newValidatedField = [
            $this->fieldToValidate => trim($requestBody[$this->fieldToValidate])
        ];
        
        return $newValidatedField;
    }
}
