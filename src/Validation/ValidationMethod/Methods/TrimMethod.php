<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\Validation\ValidationMethod\Methods;

class TrimMethod extends ValidationMethodHelper
{
    public function __invoke(): ?string
    {    
        if (
            empty($this->requestBody[$this->fieldName]) || 
            !is_string($this->requestBody[$this->fieldName])
        ) {
            return null;
        }

        return trim($this->requestBody[$this->fieldName]);
    }
}
