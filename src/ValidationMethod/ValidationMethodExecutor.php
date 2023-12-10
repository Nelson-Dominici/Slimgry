<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod;

class ValidationMethodExecutor
{
    private ValidationMethodsHandler $handler;
    private ValidationMethodInstantiator $instantiator;
    
    public function __construct(
        private array $requestBody,
        private array $bodyValidations,
        private array $customExceptionMessages
    ) {
        $this->handler  = new ValidationMethodsHandler();
        $this->instantiator  = new ValidationMethodInstantiator($customExceptionMessages);
    }
    
	 public function performFieldValidationMethods(): void
	{
		foreach ($this->bodyValidations as $fieldToValidate => $validationMethods) {
            
            $validationMethods = $this->handler->handle($validationMethods);
        
            $this->executeValidationMethod($fieldToValidate, $validationMethods);
        }
	}

    private function executeValidationMethod(string $fieldToValidate, array $validationMethods): array
    {
        foreach ($validationMethods as $validationMethod) {
    
            $validationMethodInstance = $this->instantiator->getInstance(
                $fieldToValidate, $validationMethod
            );
            
            $validationMethodInstance->execute($this->requestBody, $fieldToValidate);
        }    
    }
}
