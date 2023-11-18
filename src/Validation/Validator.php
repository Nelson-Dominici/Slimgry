<?php

namespace NelsonDominici\Slimgry\Validation;

abstract class Validator extends ValidationExecutor
{
	protected function validate(array $bodyValidations, ?array $requestBody): void
	{
		foreach ($bodyValidations as $field => $validationRules) {

            $this->checkFieldValidations($field, $validationRules);
            
            $uniqueValidations = $this->getUniqueValidations($validationRules);
            
            $this->execute($field, $uniqueValidations, $requestBody);
		}
	}
	
	private function checkFieldValidations(string $field, string $validationRules): void
	{
        if (!is_string($validationRules) || $validationRules === '') {
        
            $message = "The \"$field\" field must contain a valid Slimgry validation";

            throw new \Exception($message, 500);
        }
	}

	private function getUniqueValidations(string $validationRules): array
	{
        $uniqueValidations = [];
        
        foreach (explode('|', $validationRules) as $validation) {
        
            $key = explode(':', $validation)[0];

            $uniqueValidations[$key] = $validation;
        }

        return array_values($uniqueValidations);
	}
}
