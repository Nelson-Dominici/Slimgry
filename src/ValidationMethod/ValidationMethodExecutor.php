<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod;

class ValidationMethodExecutor
{
    private ValidationMethodsHandler $validationMethodsHandler;
    private ValidationMethodInstantiator $validationMethodInstantiator;

    public function __construct(
        private array $requestBody,
        private array $bodyValidations,
        private array $customExceptionMessages
    ) {
        $this->validationMethodsHandler  = new ValidationMethodsHandler();
        $this->validationMethodInstantiator  = new ValidationMethodInstantiator();
    }
    
	 public function performFieldValidationMethods(): void
	{
		foreach ($this->bodyValidations as $fieldToValidate => $validationMethods) {
            
            $this->validationMethodsHandler->checkFieldValidationMethods($validationMethods);
            
            $validationMethods = $this->validationMethodsHandler->getUniqueValidationMethods($validationMethods);
 
            $this->executeValidationMethod($fieldToValidate, $validationMethods);
        }
	}

    private function executeValidationMethod(string $fieldToValidate, array $validationMethods): array
    {
        foreach ($validationMethods as $validationMethod) {
        
            $validationMethodInstance = $this->validationMethodInstantiator->getInstance(
                $fieldToValidate,
                $validationMethod,
                $this->customExceptionMessages
            );
            
            $validationMethodInstance($this->requestBody, $fieldToValidate);
        }    
    }
}
