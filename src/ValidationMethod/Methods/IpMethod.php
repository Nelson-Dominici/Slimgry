<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod\Methods;

class IpMethod extends ValidationMethod
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

        $ip = $requestBodyField[$fieldToValidate];

        $exceptionMessage = 'The '.join('.', $fieldToValidateParts).' field must be a valid IP address.';

        $expression = filter_var($ip, FILTER_VALIDATE_IP) === false;

        return $this->assertAndThrow($expression, $exceptionMessage);        
    }
}
