<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\Validation;

class Validator extends ValidationMethods
{
    use ValidationMethodsParser;
    
    public function __construct(
        private array $requestBody,
        private array $bodyValidations, 
        private array $customExceptionMessages
    ) {}
    
	public function execute(): array
	{
		foreach ($this->bodyValidations as $fieldName => $validationMethods) {
            
            $this->checkFieldValidationMethods($validationMethods);
            $validationMethods = $this->getUniqueValidationMethods($validationMethods);
 
            return $this->executeValidationMethod(
                $fieldName, 
                $validationMethods
            );
        }
	}

    private function executeValidationMethod(string $fieldName, array $validationMethods): array
    {
        $requestBodyValidated = $this->requestBody;
        
        foreach ($validationMethods as $validationMethod) {

            $validationMethodParts = explode(':', $validationMethod);

            $this->checkValidationMethodExists($validationMethodParts[0]);

            $validationMethodInstance = $this->getValidationMethodInstance(
                $fieldName,
                $this->requestBody,
                $validationMethodParts,
                $this->customExceptionMessages
            );
            
            $validatedBodyFieldValue = $validationMethodInstance();
            
            if ($validatedBodyFieldValue) {
                $requestBodyValidated[$fieldName] = $validatedBodyFieldValue;
            }
        }    
        
        return $requestBodyValidated;
    }
}
