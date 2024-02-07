<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod\Methods;

class SizeMethod extends ValidationMethod
{    
    public function execute(array $requestBody): null
    {
        if (
            !array_key_exists($this->fieldToValidate, $requestBody) ||
            !$requestBody[$this->fieldToValidate] || 
            $requestBody[$this->fieldToValidate] === true
        ) {
            return null;
        }

        $validationMethodValue = $this->getNumericValue();
        $bodyFieldValue = $requestBody[$this->fieldToValidate];

        $exceptionMessage = "The {$this->fieldToValidate} field must be {$validationMethodValue} characters.";

        $expression = false;

        if (is_string($bodyFieldValue) || is_int($bodyFieldValue)) {
            $expression = strlen(strval($bodyFieldValue)) !== $validationMethodValue;
        }

        if (is_array($bodyFieldValue)) {
            $expression = count($bodyFieldValue) !== $validationMethodValue;
        }

       return $this->assertAndThrow($expression, $exceptionMessage);
    }
}
