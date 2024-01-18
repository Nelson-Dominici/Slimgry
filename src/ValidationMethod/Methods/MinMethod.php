<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod\Methods;

class MinMethod extends ValidationMethod
{
    public function execute(array $requestBody, array $validatedRequestBody): null
    {    
        if (
            empty($requestBody[$this->fieldToValidate]) || 
            $requestBody[$this->fieldToValidate] === true
        ) {
            return null;
        }

        $validationMethodValue = $this->getNumericValue();
        $bodyFieldValue = $requestBody[$this->fieldToValidate];

        $exceptionMessage = "The {$this->fieldToValidate} field cannot be less than $validationMethodValue.";

        $expression = false;

        if (is_string($bodyFieldValue) || is_int($bodyFieldValue)) {
            $expression = strlen(strval($bodyFieldValue)) < $validationMethodValue;
        }

        if (is_array($bodyFieldValue)) {
            $expression = count($bodyFieldValue) < $validationMethodValue;
        }

        return $this->assertAndThrow($expression, $exceptionMessage);
    }
}
 
