<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod\Methods;

class EmailMethod extends ValidationMethod
{    
    public function execute(array $requestBodyField, array $fieldToValidateParts, array $validationMethods): null
    {
        $fieldToValidate = end($fieldToValidateParts);
    
        if (
            $requestBodyField === [] ||
            (
                in_array('nullable', $validationMethods) && 
                $requestBodyField[$fieldToValidate] === null
            )
        ) {
            return null;
        }

        $email = $requestBodyField[$fieldToValidate];

        $exceptionMessage = 'The '.join('.', $fieldToValidateParts).' field must be a valid email.';

        $expression = filter_var($email, FILTER_VALIDATE_EMAIL) === false;

        return $this->assertAndThrow($expression, $exceptionMessage);        
    }
}
