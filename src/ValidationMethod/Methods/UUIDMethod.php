<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod\Methods;

class UUIDMethod extends ValidationMethod
{    
    public function execute(array $requestBody): null
    {
        if (!array_key_exists($this->fieldToValidate, $requestBody)) {
            return null;
        }

        $bodyUuid = $requestBody[$this->fieldToValidate];

        $exceptionMessage = "The {$this->fieldToValidate} field is not a valid uuid.";

        $pattern = '/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i';

        $expression = preg_match($pattern, $bodyUuid) === 0;
        
        return $this->assertAndThrow($expression, $exceptionMessage);        
    }
}
