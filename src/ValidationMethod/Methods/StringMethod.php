<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod\Methods;

class StringMethod extends ValidationMethod
{
    public function execute(array $requestBody, string $fieldToValidate): void
    {    
        if (!array_key_exists($this->fieldName, $this->requestBody)) {
            return;
        }

        $exceptionMessage = "The value of the {$this->fieldName} field must be a string.";

        $isString = is_string($this->requestBody[$this->fieldName]);

        $this->assertAndThrow(!$isString, $exceptionMessage);
    }
}
