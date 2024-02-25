<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod\Methods;

class GteMethod extends ValidationMethod
{    
    public function execute(array $requestBodyField, array $fieldToValidateParts): null
    {
        $fieldToValidate = end($fieldToValidateParts);
   
        if (
            $requestBodyField === [] || 
            !is_numeric($requestBodyField[$fieldToValidate])
        ) {
            return null;
        }

        $bodyFieldValue = $requestBodyField[$fieldToValidate];

        $methodValue = $this->getNumericValue();

        $exceptionMessage = 'The '.join('.', $fieldToValidateParts).' field must be greater than or equal to '.$methodValue.'.';

        if ($bodyFieldValue+0 < $methodValue) {

            $this->throwException($exceptionMessage);         
        }

        return null;
    }
}
