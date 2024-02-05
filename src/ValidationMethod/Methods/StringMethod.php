<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod\Methods;

class StringMethod extends ValidationMethod
{
    public function execute(array $requestBody): null
    {    
        if (array_key_exists($this->fieldToValidate, $requestBody)) {

            $exceptionMessage = "The {$this->fieldToValidate} field must be a string.";

            $isString = is_string($requestBody[$this->fieldToValidate]);
    
            $this->assertAndThrow(!$isString, $exceptionMessage);
        }

        return null;
    }
}
