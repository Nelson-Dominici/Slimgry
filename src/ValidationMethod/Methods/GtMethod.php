<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod\Methods;

class GtMethod extends ValidationMethod
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

        $exceptionMessage = 'The '.join('.', $fieldToValidateParts).' field must be greater than '.$methodValue.'.';;
        
        $expression = $bodyFieldValue+0 <= $methodValue;

        return $this->assertAndThrow($expression, $exceptionMessage);         
    }
}
