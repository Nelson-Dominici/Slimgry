<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\Validation;

use NelsonDominici\Slimgry\Validation\Methods\MethodHelper;

class ValidationMethod
{
    private string $validationMethodName;
    
    public function __construct(
        private string $fieldName,
        private array $requestBody,
        private array $validationMethodParts,
        private array $customExceptionMessages
    ) {
        $this->checkValidationExists();
        
        return new $validationMethodPath(
            $fieldName,
            $requestBody,
            $validationMethodParts, 
            $this->customExceptionMessage
        );        
    }
    
    private function checkValidationExists(): string
    {
        if (!isset(self::METHODS[$this->validationMethodName])) {
            throw new \Exception("Validation method '$validationMethod' does not exist.", 422);
        }
    }
    
    private function customExceptionMessage(): string
    {
        $customExceptionMessageField = $fieldName.'.'.$this->validationMethodName;

        return $customExceptionMessages[$customExceptionMessageField] ?? '';
    }
}
