<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\Validation;

abstract class Validation extends ValidationParser
{
    use Validations\LengthValidation;
    
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

            $this->$validationMethod($requestBody, $fieldName, $validationParts);
        }    
    }
    
    private function checkValidationMethodExists(string $validationMethod): void
    {
        if (!method_exists($this, $validationMethod)) {
            throw new \Exception("Validation method '$validationMethod' does not exist.", 422);
        }    
    }
}
