<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\Validation\ValidationMethod;

abstract class ValidationMethodInstantiator
{
    use ValidationMethodGroupTrait;
    
    public function getValidationMethodInstance(
        string $fieldName,
        array $requestBody,
        array $validationMethodParts,
        array $customExceptionMessages
    ): Methods\ValidationMethodHelper {
        $validationMethodName = $validationMethodParts[0];
        
        $customExceptionMessage = $this->customExceptionMessage(
            $fieldName,
            $validationMethodName,
            $customExceptionMessages
        );
        
        $validationMethodPath = $this->getValidationMethod($validationMethodName);

        return new $validationMethodPath(
            $fieldName,
            $requestBody,
            $validationMethodParts, 
            $customExceptionMessage
        );    
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
