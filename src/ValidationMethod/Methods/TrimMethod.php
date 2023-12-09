<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod\Methods;

class TrimMethod extends ValidationMethod
{
    public function execute(array $requestBody, string $fieldToValidate): ?string
    {    
        if (
            empty($this->requestBody[$this->fieldName]) || 
            !is_string($this->requestBody[$this->fieldName])
        ) {
            return null;
        }

        return trim($this->requestBody[$this->fieldName]);
    }
}
