<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\Validation\ValidationMethod\Methods;

class RequiredMethod extends ValidationMethodHelper
{
    public function __invoke(): void
    {    
        if (
            array_key_exists($this->fieldName, $this->requestBody) &&
            (
                $this->requestBody[$this->fieldName] ||
                $this->requestBody[$this->fieldName] === false ||
                $this->requestBody[$this->fieldName] === 0
            )
        ) {
            return;
        }
    
        $this->throwException('The field '.$this->fieldName.' is required');
    }
}
