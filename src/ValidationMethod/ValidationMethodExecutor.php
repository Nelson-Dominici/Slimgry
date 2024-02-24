<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod;

use NelsonDominici\Slimgry\RequestBodyHandler;

class ValidationMethodExecutor
{
    public function __construct(
        private array $bodyValidations,
        private ValidationMethodsHandler $handler,
        private RequestBodyHandler $requestBodyHandler,
        private ValidationMethodInstantiator $instantiator
    ) {}
    
	public function performFields(): array
	{
		foreach ($this->bodyValidations as $field => $validationMethods) {
            
            $validationMethods = $this->handler->removeDuplicateMethods(
                $validationMethods
            );
        
            $this->executeMethods(explode('.', $field),$validationMethods);
        }
        
        return $this->requestBodyHandler->getValidatedBody();
	}

    private function executeMethods(array $fieldToValidateParts, array $validationMethods): void
    {
        $requestBodyField = $this->requestBodyHandler->getBodyField(
            $fieldToValidateParts
        );

        foreach ($validationMethods as $validationMethod) {
            
            $this->handler->checkMethodColon($validationMethod);

            $methodInstance = $this->instantiator->getInstance(
                $fieldToValidateParts, $validationMethod
            );

            $newFieldValue = $methodInstance->execute(
                $requestBodyField,
                $fieldToValidateParts
            );

            $this->requestBodyHandler->updateValidatedBody(
                $newFieldValue,
                $fieldToValidateParts
            );
        }
    }
}
