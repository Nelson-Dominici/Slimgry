<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod;

use NelsonDominici\Slimgry\RequestBodyHadler;

class ValidationMethodExecutor
{
    public function __construct(
        private array $bodyValidations,
        private ValidationMethodsHandler $handler,
        private RequestBodyHadler $requestBodyHandler,
        private ValidationMethodInstantiator $instantiator
    ) {}
    
	 public function performFieldValidationMethods(): array
	{
		foreach ($this->bodyValidations as $fieldToValidate => $validationMethods) {
            
            $validationMethods = $this->handler->handle($validationMethods);
        
            $this->executeValidationMethod($fieldToValidate, $validationMethods);
        }
        
        return $this->requestBodyHandler->getValidatedBody();
	}

    private function executeValidationMethod(string $fieldToValidate, array $validationMethods): void
    {
        foreach ($validationMethods as $validationMethod) {
    
            $validationMethodInstance = $this->instantiator->getInstance(
                $fieldToValidate, $validationMethod
            );

            $newValidatedRequestBody = $validationMethodInstance->execute(
                $this->requestBodyHandler->getRequestBody(), 
                $this->requestBodyHandler->getValidatedBody()
            );

            $this->requestBodyHandler->updateValidatedBody($newValidatedRequestBody);
        }
    }
}
