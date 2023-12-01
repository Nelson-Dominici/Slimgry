<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\Validation;

use NelsonDominici\Slimgry\Validation\Methods\MethodHelper;

abstract class ValidationMethods
{
    protected const METHODS = [
        'min' => Methods\MinMethod::class,
        'trim' => Methods\TrimMethod::class,
        'max' => Methods\MaxMethod::class,
        'string' => Methods\StringMethod::class,
        'required' => Methods\RequiredMethod::class
    ];

    protected function checkValidationMethodExists(string $validationMethod): void
    {
        if (!array_key_exists($validationMethod, self::METHODS)) {
            throw new \Exception("Validation method '$validationMethod' does not exist.", 422);
        }    
    }

    protected function getValidationMethodInstance(string $fieldName, array $requestBody, array $validationMethodParts, array $customExceptionMessages): MethodHelper
    {
        $validationMethodPath = self::METHODS[$validationMethodParts[0]];

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
        
        if (!array_key_exists($customExceptionMessageField, $customExceptionMessages)) {
            return '';
        }
        
        return $customExceptionMessages[$customExceptionMessageField];
    }
}
