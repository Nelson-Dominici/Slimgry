<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod\Methods;

class GteMethod extends ValidationMethod
{    
    public function execute(array $requestBody): null
    {
        if (
            !array_key_exists($this->fieldToValidate, $requestBody) || 
            !is_numeric($requestBody[$this->fieldToValidate])
        ) {
            return null;
        }

        $bodyFieldValue = $requestBody[$this->fieldToValidate];

        $methodValue = $this->getNumericValue();

        $exceptionMessage = "The {$this->fieldToValidate} field must be greater than or equal to {$methodValue}.";

        if ($bodyFieldValue+0 < $methodValue) {

            $this->throwException($exceptionMessage);         
        }

        return null;
    }
}
