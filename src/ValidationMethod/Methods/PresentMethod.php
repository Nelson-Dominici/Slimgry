<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod\Methods;

class PresentMethod extends ValidationMethod
{
    public function execute(array $requestBody): null
    {    
        $exceptionMessage = 'The '.$this->fieldToValidate.' field must be present.';
        
        $expression = !array_key_exists($this->fieldToValidate, $requestBody);

        return $this->assertAndThrow($expression, $exceptionMessage);
    }
}
