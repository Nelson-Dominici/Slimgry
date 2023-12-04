<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\Validation\ValidationMethod;

abstract class ValidationMethodsHandler
{
    public function getValidationMethodInstance(): Methods\MethodHelper
        string $fieldName,
        array $requestBody,
        array $validationMethodParts,
        array $customExceptionMessages
    ): MethodHelper {
        $validationMethodName = $validationMethodParts[0];
        
        $customExceptionMessage = $this->customExceptionMessage(
            $fieldName,
            $validationMethodName,
            $customExceptionMessages
        );
        
        return new $this->validationMethodPath($validationMethodName)(
            $fieldName,
            $requestBody,
            $validationMethodParts, 
            $customExceptionMessage
        );    
    }
  
    private function validationMethodPath(string $validationMethodName): string
    {
        if (!isset(self::METHODS[$validationMethodName])) {
            throw new \Exception(
                "Validation method '$validationMethodName' does not exist.", 422
            );
        }
        
        return self::METHODS[$validationMethodName];
    }
    
    private function customExceptionMessage(
        string $fieldName, 
        string $validationMethodName,
        array $customExceptionMessages
    ): string {
        $customExceptionMessageField = $fieldName.'.'.$validationMethodName;

        return $this->customExceptionMessages[$customExceptionMessageField] ?? '';
    }
}
