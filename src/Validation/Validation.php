<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\Validation;

abstract class Validation extends ValidationMethods
{
    use ValidationMethodsParser;
    
	protected function validate(array $requestBody, array $bodyValidations, array $customExceptionMessages): array
	{
		foreach ($bodyValidations as $fieldName => $fieldValidationMethods) {
            
            $validationMethods = $this->getParsedValidationMethods($fieldValidationMethods);
 
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
            
            $customExceptionMessage = $this->customExceptionMessage(
                $fieldName, 
                $validationMethodParts[0], 
                $customExceptionMessages
            );
            
            $validationMethodPath = self::METHODS[$validationMethodParts[0]];

            $validationMethodInstance = new $validationMethodPath(
                $fieldName,
                $requestBody,
                $validationMethodParts, 
                $customExceptionMessage
           );
            
            $validatedBodyFieldValue = $validationMethodInstance();
            
            if ($validatedBodyFieldValue) {
                $requestBodyValidated[$fieldName] = $validatedBodyFieldValue;
            }
        }    
        
        return $requestBodyValidated;
    }
    
    private function customExceptionMessage(string $fieldName, string $validationMethod, array $customExceptionMessages): string
    {
        $customExceptionMessageField = $fieldName.'.'.$validationMethod;
        
        if (!array_key_exists($customExceptionMessageField, $customExceptionMessages)) {
            return '';
        }
        
        return $customExceptionMessages[$customExceptionMessageField];
    }
}
