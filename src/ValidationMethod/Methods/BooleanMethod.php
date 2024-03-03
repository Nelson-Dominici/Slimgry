<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod\Methods;

class BooleanMethod extends ValidationMethod
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

        $bodyFieldValue = $requestBodyField[$fieldToValidate];

        $exceptionMessage = 'The '.join('.', $fieldToValidateParts).' field must be a valid boolean.';

        $expression = !is_bool($bodyFieldValue);

        return $this->assertAndThrow($expression, $exceptionMessage);        
    }
}
