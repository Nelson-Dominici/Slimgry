<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod;

abstract class ValidationMethodInstantiator
{    
    use ValidationMethodGroupTrait;
    
    public function getValidationMethodInstance(
        string $fieldToValidate,
        array $requestBody,
        array $validationMethodParts,
        array $customExceptionMessages
    ): Methods\ValidationMethodHelper {
        $validationMethodName = $validationMethodParts[0];
        
        $customExceptionMessage = $this->customExceptionMessage(
            $fieldToValidate,
            $validationMethodName,
            $customExceptionMessages
        );
        
        $validationMethodPath = $this->getValidationMethod($validationMethodName);

        return new $validationMethodPath(
            $fieldToValidate,
            $requestBody,
            $validationMethodParts, 
            $customExceptionMessage
        );    
    }
    
    private function customExceptionMessage(
        string $fieldToValidate, 
        string $validationMethodName,
        array $customExceptionMessages
    ): string {
        $customExceptionMessageField = $fieldToValidate.'.'.$validationMethodName;

        return $customExceptionMessages[$customExceptionMessageField] ?? '';
    }
}
