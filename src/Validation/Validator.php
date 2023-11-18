<?php

namespace NelsonDominici\Slimgry\Validation;

abstract class Validator extends ValidationExecutor
{
	protected function validate(array $bodyValidations, ?array $requestBody): void
	{
		foreach ($bodyValidations as $field => $fieldValidations) {
		
            $this->checkFieldValidations($field, $fieldValidations);
            
            $uniqueValidations = $this->getUniqueValidations($fieldValidations);
            
            $this->execute($field, $uniqueValidations, $requestBody);
        }
	}
	
	private function checkFieldValidations(string $field, string $fieldValidations): void
	{
        $exceptionMessage  = "The \"$field\" field must contain a valid Slimgry validation";
        
        if (!is_string($fieldValidations) || $fieldValidations === '') {
        
                throw new \Exception('$exceptionMessage' , 500);                      
        }
        
        foreach (explode('|', $fieldValidations) as $validation) {
            
            $validationParts = explode(':', $validation);

            if (count($validationParts) > 2) {
            
                throw new \Exception($exceptionMessage, 500);                        
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
