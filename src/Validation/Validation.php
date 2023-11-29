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

    private function executeValidationMethod(string $fieldName, array $requestBody, array $parsedValidations): void
    {
        foreach ($parsedValidations as $parsedValidation) {

            $validationParts = explode(':', $parsedValidation);

            $this->checkValidationMethodExists($validationParts[0]);
            
            $validationMethodPath = self::METHODS[$validationParts[0]];

            $validationMethodInstance = new $validationMethodPath(
                $fieldName,
                $requestBody,
                $validationParts, 
                ''
           );

            $validationMethodInstance();
        }    
    }
}
