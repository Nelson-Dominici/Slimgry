<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\Validation;

abstract class Validation extends ValidationMethods
{
    use ValidationParser;
    
	protected function validate(array $bodyValidations, ?array $requestBody): void
	{
		foreach ($bodyValidations as $fieldName => $fieldValidations) {
            
            $parsedValidations = $this->getParserdValidations($fieldValidations);

            $this->executeValidationMethod(
                $fieldName, 
                $requestBody,
                $parsedValidations
            );
        }
	}

    private function executeValidationMethod(string $fieldName, ?array $requestBody, array $parsedValidations): void
    {
        foreach ($parsedValidations as $parsedValidation) {

            $validationParts = explode(':', $parsedValidation);
    
            $validationMethod = $validationParts[0];

            $this->checkValidationMethodExists($validationMethod);
            
            $validationMethodPath = self::METHODS[$validationMethod];
            
            $methodInstance = new $validationMethodPath();
            
            $methodInstance($requestBody, $fieldName, $validationParts);
        }    
    }
}
