<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\Validation\Methods;

class RequiredMethod extends MethodHelper
{
    public function __invoke(): void
    {
        $exceptionMessage = 'The field '.$this->fieldName.' is required';
        
        $expression = empty($this->requestBody[$this->fieldName]);
        
        $this->assertAndThrow($expression , $exceptionMessage, 400);
    }
}
