<?php

namespace NelsonDominici\Slimgry\Validation;

abstract class Validator extends ValidationExecutor
{
	protected function validate(array $bodyValidations, ?array $requestBody): void
	{
		foreach ($bodyValidations as $field => $validations) {

            $this->checkFieldValidations($validations);
            
            $uniqueValidations = $this->getUniqueValidations($validations);
            
            $this->execute($field, $uniqueValidations, $requestBody);
		}
	}
	
	private function checkFieldValidations(string $fieldValidations): void
	{
        if (!is_string($fieldValidations) || $fieldValidations === '') {
        
            $message = "The \"$field\" field must contain a valid Slimgry validation";

            throw new \Exception($message, 500);
        }
	}

	private function getUniqueValidations(string $fieldValidations): array
	{
        $uniqueValidations = [];
        
        foreach (explode('|', $fieldValidations) as $validation) {
        
            $key = explode(':', $validation)[0];

            $uniqueValidations[$key] = $validation;
        }

        return array_values($uniqueValidations);
	}
}
