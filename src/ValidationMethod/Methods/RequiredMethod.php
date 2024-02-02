<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod\Methods;

class RequiredMethod extends ValidationMethod
{
    public function execute(array $requestBody): null
    {    
        if (
            !array_key_exists($this->fieldToValidate, $requestBody) ||
            $requestBody[$this->fieldToValidate] === '' ||
            $requestBody[$this->fieldToValidate] === [] ||
            $requestBody[$this->fieldToValidate] === null
        ) {
            $this->throwException('The '.$this->fieldToValidate.' field is required.');
        }

        return null;
    }
}
