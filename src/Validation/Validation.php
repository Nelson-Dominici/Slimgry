<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\Validation;

abstract class Validation extends ValidationMethods
{
    use ValidationParser;
    
	protected function validate(array $bodyValidations, ?array $requestBody, array $customExceptionMessages): array
	{
        $requestBody ??= [];

		foreach ($bodyValidations as $fieldName => $fieldValidations) {
            
            $parsedValidations = $this->getParserdValidations($fieldValidations);
            
            return $this->executeValidationMethod(
                $fieldName, 
                $requestBody,
                $parsedValidations,
                $customExceptionMessages
            );
        }
	}

    private function executeValidationMethod(string $fieldName, array $requestBody, array $parsedValidations, array $customExceptionMessages): array
    {
        $validated = $requestBody;
        
        foreach ($parsedValidations as $parsedValidation) {

            $validationParts = explode(':', $parsedValidation);

            $this->checkValidationMethodExists($validationParts[0]);
            
            $customExceptionMessage = $this->customExceptionMessage(
                $fieldName, 
                $validationParts[0], 
                $customExceptionMessages
            );
            
            $validationMethodPath = self::METHODS[$validationParts[0]];

            $validationMethodInstance = new $validationMethodPath(
                $fieldName,
                $requestBody,
                $validationParts, 
                $customExceptionMessage
           );
            
            $validatedBodyField = $validationMethodInstance();
            
            if ($validatedBodyField) {
                $validated[$fieldName] = $validatedBodyField;
            }
        }    
        
        return $validated;
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
