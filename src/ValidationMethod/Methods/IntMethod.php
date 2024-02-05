<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod\Methods;

class IntMethod extends ValidationMethod
{    
    public function execute(array $requestBody): null
    {
        if (array_key_exists($this->fieldToValidate, $requestBody)) {

            $intValue = $requestBody[$this->fieldToValidate];

            $exceptionMessage = "The {$this->fieldToValidate} field does not have a integer value.";
    
            $expression = is_int($intValue) === false;

            $this->assertAndThrow($expression, $exceptionMessage);    
        }
     
        return null;
    }
}
