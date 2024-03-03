<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod\Methods;

class SizeMethod extends ValidationMethod
{    
    public function execute(array $requestBodyField, array $fieldToValidateParts, array $validationMethods): null
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

        $exceptionMessage = 'The '.join('.', $fieldToValidateParts).' field must be '.$validationMethodValue.' characters.';

        $expression = false;

        if (is_string($bodyFieldValue) || is_int($bodyFieldValue)) {
            $expression = strlen(strval($bodyFieldValue)) !== $validationMethodValue;
        }

        if (is_array($bodyFieldValue)) {
            $expression = count($bodyFieldValue) !== $validationMethodValue;
        }

       return $this->assertAndThrow($expression, $exceptionMessage);
    }
}
