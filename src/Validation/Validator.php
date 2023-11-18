<?php

namespace NelsonDominici\Slimgry\Validation;

abstract class Validator extends ValidationExecutor
{
	protected function validate(array $bodyValidations, ?array $requestBody): void
	{
		foreach ($bodyValidations as $field => $fieldValidations) {
		
            $this->checkFieldValidations($fieldValidations);
            
            $uniqueValidations = $this->getUniqueValidations($fieldValidations);
            
            $this->execute($field, $uniqueValidations, $requestBody);
        }
	}
	
	private function checkFieldValidations(string $fieldValidations): void
	{        
        if (!is_string($fieldValidations) || $fieldValidations === '') {
        
                throw new \Exception('Slimgry validations must be a string.' , 422);                      
        }
        
        foreach (explode('|', $fieldValidations) as $validation) {
            
            $validationParts = explode(':', $validation);

            if (count($validationParts) > 2) {
            
                throw new \Exception('Invalid validation format. Use only one colon (:).', 422);
            }
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
