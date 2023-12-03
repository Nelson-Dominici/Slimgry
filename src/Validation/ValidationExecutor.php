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
//         $this->execute();
//         $this->$validatedBody = $this->getValidatedBody();
    }
    
	 function execute(): array
	{
		foreach ($this->bodyValidations as $fieldName => $validationMethods) {
            
            $this->checkFieldValidationMethods($validationMethods);
            $validationMethods = $this->getUniqueValidationMethods($validationMethods);
 
            return $this->executeValidationMethod($fieldName, $validationMethods);
        }
	}

    private function executeValidationMethod(string $fieldName, array $validationMethods): array
    {
        $newBodyFieldValue = $this->requestBody;
        
        foreach ($validationMethods as $validationMethod) {

            $validationMethodParts = explode(':', $validationMethod);
            
            $validationMethodInstance = $this->getValidationMethodInstance(
                $fieldName,
                $this->requestBody,
                $validationMethodParts,
                $this->customExceptionMessages
            );
            
            $newBodyFieldValue = $validationMethodInstance();
            
            if ($newBodyFieldValue === null) {
                $requestBodyValidated[$fieldName] = $newBodyFieldValue;
            }
        }    
        
        return $requestBodyValidated;
    }
    
    private function newBodyFieldValue()
    {
        return 'name';
    }
    
    // FAZER BAGUI PRA JUNTAR O BAGUI
}
