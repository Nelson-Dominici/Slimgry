<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod\Methods;

class StringMethod extends ValidationMethod
{
    public function execute(array $requestBody, array $validatedRequestBody): null
    {    
        if (!array_key_exists($this->fieldToValidate, $requestBody)) {
            return null;
        }

        $exceptionMessage = "The value of the {$this->fieldToValidate} field must be a string.";

        $isString = is_string($requestBody[$this->fieldToValidate]);

        return $this->assertAndThrow(!$isString, $exceptionMessage);
    }
}
