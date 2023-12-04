<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\Validation;

use NelsonDominici\Slimgry\Validation\Methods\MethodHelper;

abstract class ValidationMethods
{
    private function getValidationMethodPath(string $validationMethod): string
    {
        if (!isset(self::METHODS[$validationMethod])) {
            throw new \Exception("Validation method '$validationMethod' does not exist.", 422);
        }    
        
        return self::METHODS[$validationMethod];
    }

    protected function getValidationMethodInstance(string $fieldName, array $requestBody, array $validationMethodParts, array $customExceptionMessages): MethodHelper
    {
        $validationMethodPath = $this->getValidationMethodPath($validationMethodParts[0]);
        
        $customExceptionMessage = $this->customExceptionMessage(
            $fieldName, 
            $validationMethodParts[0], 
            $customExceptionMessages
        );
        
        return new $validationMethodPath(
            $fieldName,
            $requestBody,
            $validationMethodParts, 
            $customExceptionMessage
        );        
    }
    
    private function customExceptionMessage(string $fieldName, string $validationMethod, array $customExceptionMessages): string
    {
        $customExceptionMessageField = $fieldName.'.'.$validationMethod;

        return $customExceptionMessages[$customExceptionMessageField] ?? '';
    }
}
