<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod\Methods;

class BooleanMethod extends ValidationMethod
{    
    public function execute(array $requestBodyField, array $fieldToValidateParts, array $validationMethods): null
    {
        if ($requestBodyField === []) {
            return null;
        }

        $fieldToValidate = end($fieldToValidateParts);

        $bodyFieldValue = $requestBodyField[$fieldToValidate];

        $exceptionMessage = 'The '.join('.', $fieldToValidateParts).' field must be a valid boolean.';

        $expression = !is_bool($bodyFieldValue);

        return $this->assertAndThrow($expression, $exceptionMessage);        
    }
}
