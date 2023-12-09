<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod;

class CustomExceptionMessageProvider
{
    public function getCustomMessage(
        string $fieldToValidate, 
        string $validationMethod,
        array $customExceptionMessages
    ): string 
    {
        $validationMethodName = explode(':', $validationMethod)[0];

        $customExceptionMessageField = $fieldToValidate.'.'.$validationMethodName;

        return $customExceptionMessages[$customExceptionMessageField] ?? '';
    }
}
