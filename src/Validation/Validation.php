<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\Validation;

abstract class Validation extends ValidationParser
{
    const METHODS = [
        'max' => Methods\MaxMethod::class
    ];
    
	protected function validate(array $bodyValidations, ?array $requestBody): void
	{
		foreach ($bodyValidations as $fieldName => $fieldValidations) {
            
            $parsedValidations = $this->getParserdValidations($fieldValidations);

            $this->executeValidationMethod($fieldName, $parsedValidations, $requestBody);
        }
	}

    private function executeValidationMethod(string $fieldName, array $parsedValidations, ?array $requestBody): void
    {
        foreach ($parsedValidations as $validation) {

            $validationParts = explode(':', $validation);
    
            $validationMethod = $validationParts[0];

            $this->checkValidationMethodExists($validationMethod);
            
            $validationMethodPath = self::METHODS[$validationMethod];
            
            $methodInstance = new $validationMethodPath();
            
            $methodInstance($requestBody, $fieldName, $validationParts);
        }    
    }
    
    private function checkValidationMethodExists(string $validationMethod): void
    {
        if (!array_key_exists($validationMethod, self::METHODS)) {
            throw new \Exception("Validation method '$validationMethod' does not exist.", 422);
        }    
    }
}
