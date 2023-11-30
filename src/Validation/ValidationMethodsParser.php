<?php 

declare(strict_types=1);

namespace NelsonDominici\Slimgry\Validation;

 trait ValidationMethodsParser
{
    protected function getParsedValidationMethods(string $fieldValidationMethods): array
    {
        $this->checkFieldValidationMethods($fieldValidationMethods);
        
        return $this->getUniqueValidationMethods($fieldValidationMethods);
    }
    
	private function checkFieldValidationMethods(string $fieldValidationMethods): void
	{        
        if (!is_string($fieldValidationMethods) || $fieldValidationMethods === '') {
            throw new \Exception('Slimgry validations must be a string.' , 422);                      
        }
        
        $pattern = '/[^|]*:[^|]*:[^|]*/'; //Checking if there is more than one (:) in a validation method.

        if (preg_match($pattern, $fieldValidationMethods)) {
            throw new \Exception('Invalid validation method format. Use only one colon (:).', 422);
        }
    }

	private function getUniqueValidationMethods(string $fieldValidationMethods): array
	{
        $uniqueValidationMethods = [];
        
        foreach (explode('|', $fieldValidationMethods) as $fieldValidationMethod) {
        
            $validationMethod = explode(':', $fieldValidationMethod)[0];

            $uniqueValidationMethods[$validationMethod] = $fieldValidationMethod;
        }

        return array_values($uniqueValidationMethods);
	}
}
