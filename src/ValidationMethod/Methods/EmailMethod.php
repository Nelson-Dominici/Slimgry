<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod\Methods;

class EmailMethod extends ValidationMethod
{    
    public function execute(array $requestBody): null
    {
        if (!array_key_exists($this->fieldToValidate, $requestBody)) {
            return null;
        }

        $email = $requestBody[$this->fieldToValidate];

        $exceptionMessage = "The {$this->fieldToValidate} field is not a valid email.";

        $expression = filter_var($email, FILTER_VALIDATE_EMAIL) === false;

        return $this->assertAndThrow($expression, $exceptionMessage);        
    }
}
