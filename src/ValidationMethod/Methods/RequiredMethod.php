<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod\Methods;

class RequiredMethod extends ValidationMethod
{
    public function execute(array $requestBody, array $validatedRequestBody): null
    {    
        if (
            array_key_exists($this->fieldToValidate, $requestBody) &&
            (
                $requestBody[$this->fieldToValidate] ||
                $requestBody[$this->fieldToValidate] === false ||
                $requestBody[$this->fieldToValidate] === 0
            )
        ) {
            return null;
        }
    
        $this->throwException('The field '.$this->fieldToValidate.' is required');
    }
}
