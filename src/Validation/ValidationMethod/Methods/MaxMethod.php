<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\Validation\Methods;

class MaxMethod extends MethodHelper
{    
    public function __invoke(): void
    {
        if (
            empty($this->requestBody[$this->fieldName]) || 
            $this->requestBody[$this->fieldName] === true
        ) {
            return;
        }

        $validationMethodValue = $this->validationMethodValue();
        $bodyFieldValue = $this->requestBody[$this->fieldName];

        $exceptionMessage = "The {$this->fieldName} field cannot be greater than $validationMethodValue";

        $expression = false;

        if (is_string($bodyFieldValue) || is_int($bodyFieldValue)) {
            $expression = strlen(strval($bodyFieldValue)) > $validationMethodValue;
        }

        if (is_array($bodyFieldValue)) {
            $expression = count($bodyFieldValue) > $validationMethodValue;
        }

        $this->assertAndThrow($expression, $exceptionMessage);
    }
}