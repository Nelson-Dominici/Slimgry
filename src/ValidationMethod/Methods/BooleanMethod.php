<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod\Methods;

class BooleanMethod extends ValidationMethod
{    
    public function execute(array $requestBody): null
    {
        if (!array_key_exists($this->fieldToValidate, $requestBody)) {
            return null;
        }

        $bodyFieldValue = $requestBody[$this->fieldToValidate];

        $exceptionMessage = "The {$this->fieldToValidate} field is not a valid boolean.";

        $expression = !is_bool($bodyFieldValue);

        return $this->assertAndThrow($expression, $exceptionMessage);        
    }
}
