<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod\Methods;

class MinMethod extends ValidationMethod
{
    public function execute(array $requestBody, string $fieldToValidate): void
    {    
        if (
            empty($requestBody[$fieldToValidate]) || 
            $requestBody[$fieldToValidate] === true
        ) {
            return;
        }

        $validationMethodValue = $this->validationMethodValue();
        $bodyFieldValue = $requestBody[$fieldToValidate];

        $exceptionMessage = "The {$fieldToValidate} field cannot be less than $validationMethodValue";

        $expression = false;

        if (is_string($bodyFieldValue) || is_int($bodyFieldValue)) {
            $expression = strlen(strval($bodyFieldValue)) < $validationMethodValue;
        }

        if (is_array($bodyFieldValue)) {
            $expression = count($bodyFieldValue) < $validationMethodValue;
        }

        $this->assertAndThrow($expression, $exceptionMessage);
    }
}
 
