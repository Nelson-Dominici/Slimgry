<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod;

class CustomExceptionMessageProvider
{
    public function __construct(
        private array $customExceptionMessages
    ) {}
    
    public function getMessage(array $fieldToValidateParts, string $validationMethodKey): string 
    {
        $customExceptionMessageField = join('.', $fieldToValidateParts).'.'.$validationMethodKey;

        return $this->customExceptionMessages[$customExceptionMessageField] ?? '';
    }
}
