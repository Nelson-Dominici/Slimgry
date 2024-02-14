<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod\Methods;

class ArrayMethod extends ValidationMethod
{    
    public function execute(array $requestBody): null
    {
        if (!array_key_exists($this->fieldToValidate, $requestBody)) {
            return null;
        }

        $bodyFieldValue = $requestBody[$this->fieldToValidate];

        $exceptionMessage = "The {$this->fieldToValidate} field is not a valid array.";

        $expression = !is_array($bodyFieldValue);

        return $this->assertAndThrow($expression, $exceptionMessage);        
    }
}
