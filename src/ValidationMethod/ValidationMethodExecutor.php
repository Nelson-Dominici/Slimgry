<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod;

use NelsonDominici\Slimgry\RequestBodyHadler;

class ValidationMethodExecutor
{
    private ValidationMethodsHandler $handler;
    
    public function __construct(
        private array $bodyValidations,
        private RequestBodyHadler $requestBodyHandler,
        private ValidationMethodInstantiator $instantiator
    ) {
        $this->handler  = new ValidationMethodsHandler();
    }
    
	 public function performFieldValidationMethods(): array
	{
		foreach ($this->bodyValidations as $fieldToValidate => $validationMethods) {
            
            $validationMethods = $this->handler->handle($validationMethods);
        
            $this->executeValidationMethod($fieldToValidate, $validationMethods);
        }
        
        return $this->requestBodyHandler->validatedBody;
	}

    private function executeValidationMethod(string $fieldToValidate, array $validationMethods): void
    {
        foreach ($validationMethods as $validationMethod) {
    
            $validationMethodInstance = $this->instantiator->getInstance(
                $fieldToValidate, $validationMethod
            );

            $requestBody = $this->requestBodyHandler->requestBody;
            $validatedRequestBody = $this->requestBodyHandler->validatedBody;

            $newValidatedRequestBody = $validationMethodInstance->execute(
                $requestBody, $validatedRequestBody
            );

            $this->requestBodyHandler->updateValidatedBody($newValidatedRequestBody);
        }
    }
}
