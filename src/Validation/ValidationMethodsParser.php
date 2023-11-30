<?php 

declare(strict_types=1);

namespace NelsonDominici\Slimgry\Validation;

 trait ValidationMethodsParser
{
    protected function getParserdValidations(string $fieldValidations): array
    {
        $this->checkFieldValidations($fieldValidations);
        
        return $this->getUniqueFieldValidations($fieldValidations);
    }
    
	private function checkFieldValidations(string $fieldValidations): void
	{        
        if (!is_string($fieldValidations) || $fieldValidations === '') {
            throw new \Exception('Slimgry validations must be a string.' , 422);                      
        }
        
        $pattern = '/[^|]*:[^|]*:[^|]*/'; //Checking if there is more than one (:) in a validation method.

        if (preg_match($pattern, $fieldValidations)) {
            throw new \Exception('Invalid validation method format. Use only one colon (:).', 422);
        }
    }

	private function getUniqueFieldValidations(string $fieldValidations): array
	{
        $uniqueValidations = [];
        
        foreach (explode('|', $fieldValidations) as $fieldValidation) {
        
            $validationMethod = explode(':', $fieldValidation)[0];

            $uniqueValidations[$validationMethod] = $fieldValidation;
        }

        return array_values($uniqueValidations);
	}
}