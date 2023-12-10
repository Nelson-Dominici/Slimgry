<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod;

class CustomExceptionMessageProvider
{
    public function __construct(
        private array $customExceptionMessages
    ) {}
    
    public function getCustomMessage(string $fieldToValidate, string $validationMethodName): string 
    {
        $customExceptionMessageField = $fieldToValidate.'.'.$validationMethodName;

        return $this->customExceptionMessages[$customExceptionMessageField] ?? '';
    }
}
