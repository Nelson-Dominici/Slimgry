<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod\Methods;

class UUIDMethod extends ValidationMethod
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

        $bodyUuid = $requestBodyField[$fieldToValidate];

        $exceptionMessage = 'The '.$fieldToValidate.' field must be a valid uuid.';

        if (!is_string($bodyUuid)) {
            $this->throwException($exceptionMessage);
        }

        $pattern = '/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i';

        $expression = preg_match($pattern, trim($bodyUuid)) === 0;
        
        return $this->assertAndThrow($expression, $exceptionMessage);        
    }
}
