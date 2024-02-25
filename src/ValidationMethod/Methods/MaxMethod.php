<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod\Methods;

class MaxMethod extends ValidationMethod
{    
    public function execute(array $requestBodyField, array $fieldToValidateParts): null
    {
        $fieldToValidate = end($fieldToValidateParts);
       
        if (
            $requestBodyField === [] ||
            !$requestBodyField[$fieldToValidate] || 
            $requestBodyField[$fieldToValidate] === true
        ) {
            return null;
        }
        
        $validationMethodValue = $this->getNumericValue();
        $bodyFieldValue = $requestBodyField[$fieldToValidate];

        $exceptionMessage = 'The '.join('.', $fieldToValidateParts).' field cannot be greater than '.$validationMethodValue.'.';

        $expression = false;

        if (is_string($bodyFieldValue) || is_int($bodyFieldValue)) {
            $expression = strlen(trim(strval($bodyFieldValue))) > $validationMethodValue;
        }

        if (is_array($bodyFieldValue)) {
            $expression = count($bodyFieldValue) > $validationMethodValue;
        }

        return $this->assertAndThrow($expression, $exceptionMessage);
    }
}
