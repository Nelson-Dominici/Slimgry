<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\Validation;

class ValidationExecutor extends ValidationMethods
{
    use ValidationMethodsParser;
    
    private array $validatedBody;
        
    public function __construct(
        private array $requestBody,
        private array $bodyValidations,
        private array $customExceptionMessages
    ) {
        $this->$validatedBody = $this->getValidatedBody();
        $this->execute();
    }
    
	 private function execute(): void
	{
		foreach ($this->bodyValidations as $fieldName => $validationMethods) {
            
            $this->checkFieldValidationMethods($validationMethods);
            $validationMethods = $this->getUniqueValidationMethods($validationMethods);
 
            $this->executeValidationMethod($fieldName, $validationMethods);
        }
	}

    private function executeValidationMethod(string $fieldName, array $validationMethods): array
    {
        foreach ($validationMethods as $validationMethod) {

            $validationMethodParts = explode(':', $validationMethod);
            
            $validationMethodInstance = $this->getValidationMethodInstance(
                $fieldName,
                $this->requestBody,
                $validationMethodParts,
                $this->customExceptionMessages
            );
            
            $validationMethodInstance()
        }    
    }
}
