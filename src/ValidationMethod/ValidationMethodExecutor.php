<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod;

use NelsonDominici\Slimgry\ValidationMethod\{
    ValidationMethodsParser,    
    ValidationMethodInstantiator
};

class ValidationMethodExecutor
{
    use ValidationMethodsParser;
    
    private ValidationMethodInstantiator $validationMethodInstantiator;

    public function __construct(
        private array $requestBody,
        private array $bodyValidations,
        private array $customExceptionMessages
    ) {
        $this->validationMethodInstantiator  = new ValidationMethodInstantiator();
    }
    
	 public function performFieldValidationMethods(): void
	{
		foreach ($this->bodyValidations as $fieldToValidate => $validationMethods) {
            
            $this->checkFieldValidationMethods($validationMethods);
            $validationMethods = $this->getUniqueValidationMethods($validationMethods);
 
            $this->executeValidationMethod($fieldToValidate, $validationMethods);
        }
	}

    private function executeValidationMethod(string $fieldToValidate, array $validationMethods): array
    {
        foreach ($validationMethods as $validationMethod) {
        
            $validationMethodInstance = $this->validationMethodInstantiator->getValidationMethodInstance(
                $fieldToValidate,
                $validationMethod,
                $this->customExceptionMessages
            );
            
            $validationMethodInstance($this->requestBody, $fieldToValidate);
        }    
    }
}
