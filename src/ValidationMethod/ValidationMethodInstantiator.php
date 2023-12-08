<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod;

abstract class ValidationMethodInstantiator
{    
    public function getValidationMethodInstance(
        string $fieldToValidate,
        string $validationMethod,
        array $customExceptionMessages
    ): Methods\ValidationMethodHelper {
    
        $validationMethodParts = explode(':', $validationMethod);
    
        $validationMethodName = $validationMethodParts[0];
        
        $customExceptionMessage = $this->customExceptionMessage(
            $fieldToValidate,
            $validationMethodName,
            $customExceptionMessages
        );
        
        $validationMethodPath = $this->validationMethod($validationMethodName);

        return new $validationMethodPath(
            $validationMethodParts, 
            $customExceptionMessage
        );    
    }

    private function validationMethod(string $validationMethodName): string
    {
        $validationMethodPath = __NAMESPACE__.'\Methods\\'.ucfirst($validationMethodName)."Method";
        
        if (class_exists($validationMethodPath)) {
            return $validationMethodPath;
        } 
        
        throw new \Exception(
            "Validation method '$validationMethodName' does not exist.", 422
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
