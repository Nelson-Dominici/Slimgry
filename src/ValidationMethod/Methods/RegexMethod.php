<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod\Methods;

class RegexMethod extends ValidationMethod
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

        $exceptionMessage = 'The '.join('.', $fieldToValidateParts).' field format is invalid.';

        if (!is_string($bodyFieldValue)) {
            $this->throwException($exceptionMessage);
        }

        $pattern = $this->validationParts[1];

        $expression = preg_match($pattern, $bodyFieldValue) === 0;

        return $this->assertAndThrow($expression, $exceptionMessage);        
    }
}
