<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod\Methods;

class StringMethod extends ValidationMethod
{
    public function execute(array $requestBody, string $fieldToValidate): void
    {    
        if (!array_key_exists($fieldToValidate, $requestBody)) {
            return;
        }

        $exceptionMessage = "The value of the {$fieldToValidate} field must be a string.";

        $isString = is_string($requestBody[$fieldToValidate]);

        $this->assertAndThrow(!$isString, $exceptionMessage);
    }
}
