<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod\Methods;

class TrimMethod extends ValidationMethod
{
    public function execute(array $requestBody): ?array
    {
        if (
            empty($requestBody[$this->fieldToValidate]) || 
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
