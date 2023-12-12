<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod\Methods;

class TrimMethod extends ValidationMethod
{
    public string $type = 'modeler';

    public function execute(array $requestBody, string $fieldToValidate): ?array
    {    
        if (
            empty($requestBody[$fieldToValidate]) || 
            !is_string($requestBody[$fieldToValidate])) 
        {
            return null;
        }

        return ['newBodyFieldValue' => trim($requestBody[$fieldToValidate])];
    }
}
