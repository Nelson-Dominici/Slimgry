<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod;

class CustomExceptionMessageProvider
{
    public function getCustomMessage(
        string $fieldToValidate, 
        string $validationMethodName,
        array $customExceptionMessages
    ): string 
    {
        $customExceptionMessageField = $fieldToValidate.'.'.$validationMethodName;

        return $customExceptionMessages[$customExceptionMessageField] ?? '';
    }
}
