<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\Validation\ValidationMethod;

abstract class ValidationMethodInstantiator
{
    use MethodsGroup;
    
    public function getValidationMethodInstance(
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
        
        $validationMethodPath = $this->validationMethodPath($validationMethodName);

        return new $validationMethodPath(
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
