<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\Validation\Methods;

class StringMethod extends MethodHelper
{
    public function __invoke(): void
    {    
        if (!array_key_exists($this->fieldName, $this->requestBody)) {
            return;
        }

        $exceptionMessage = "The value of the {$this->fieldName} field must be a string.";

        $isString = is_string($this->requestBody[$this->fieldName]);

        $this->assertAndThrow(!$isString, $exceptionMessage);
    }
}
