<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod\Methods;

class RequiredMethod extends ValidationMethod
{
    public function execute(array $requestBody, string $fieldToValidate): void
    {    
        if (
            array_key_exists($fieldToValidate, $requestBody) &&
            (
                $requestBody[$fieldToValidate] ||
                $requestBody[$fieldToValidate] === false ||
                $requestBody[$fieldToValidate] === 0
            )
        ) {
            return;
        }
    
        $this->throwException('The field '.$fieldToValidate.' is required');
    }
}
