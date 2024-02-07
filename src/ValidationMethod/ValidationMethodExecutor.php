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
    
	 public function performFields(): array
	{
		foreach ($this->bodyValidations as $fieldToValidate => $validationMethods) {
            
            $validationMethods = $this->handler->removeDuplicateMethods($validationMethods);
        
            $this->executeMethods($fieldToValidate, $validationMethods);
        }
        
        return $this->requestBodyHandler->getValidatedBody();
	}

    private function executeMethods(string $fieldToValidate, array $validationMethods): void
    {
        foreach ($validationMethods as $validationMethod) {
            
            $this->handler->checkMethodColon($validationMethod);

            $validationMethodInstance = $this->instantiator->getInstance(
                $fieldToValidate, $validationMethod
            );

            $newValidatedField = $validationMethodInstance->execute(
                $this->requestBodyHandler->getRequestBody(), 
            );

            $this->requestBodyHandler->updateValidatedBody($newValidatedField);
        }
    }
}
