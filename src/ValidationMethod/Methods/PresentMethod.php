<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod\Methods;

class PresentMethod extends ValidationMethod
{
    public function execute(array $requestBodyField, array $fieldToValidateParts, array $validationMethods): null
    {    
        $exceptionMessage = 'The '.join('.',$fieldToValidateParts).' field must be present.';
        
        $expression = $requestBodyField === [];

        return $this->assertAndThrow($expression, $exceptionMessage);
    }
}
