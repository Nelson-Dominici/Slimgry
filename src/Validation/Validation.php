<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\Validation;

abstract class Validation extends ValidationMethods
{
    use ValidationMethodsParser;
    
	protected function validate(array $requestBody, array $bodyValidations, array $customExceptionMessages): array
	{
		foreach ($bodyValidations as $fieldName => $fieldValidationMethods) {
            
            $this->checkFieldValidationMethods($fieldValidationMethods);
            $validationMethods = $this->getUniqueValidationMethods($fieldValidationMethods);
 
            return $this->executeValidationMethod(
                $fieldName, 
                $requestBody,
                $validationMethods,
                $customExceptionMessages
            );
        }
	}

    private function executeValidationMethod(string $fieldName, array $requestBody, array $validationMethods, array $customExceptionMessages): array
    {
        $requestBodyValidated = $requestBody;
        
        foreach ($validationMethods as $validationMethod) {

            $validationMethodParts = explode(':', $validationMethod);

            $this->checkValidationMethodExists($validationMethodParts[0]);

            $validationMethodInstance = $this->getValidationMethodInstance(
                $fieldName,
                $requestBody,
                $validationMethodParts,
                $customExceptionMessages
            );
            
            $validatedBodyFieldValue = $validationMethodInstance();
            
            if ($validatedBodyFieldValue) {
                $requestBodyValidated[$fieldName] = $validatedBodyFieldValue;
            }
        }    
        
        return $requestBodyValidated;
    }
}
