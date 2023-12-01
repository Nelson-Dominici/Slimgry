<?php 

declare(strict_types=1);

namespace NelsonDominici\Slimgry\Validation;

use NelsonDominici\Slimgry\Exceptions\InvalidValidationMethodsException;

 trait ValidationMethodsParser
{
    protected function checkFieldValidationMethods(mixed $fieldValidationMethods): void
	{        
        if (!is_string($fieldValidationMethods) || $fieldValidationMethods === '') {
            throw new InvalidValidationMethodsException(
                'Methods validation must be a string.' , $fieldValidationMethods
            );                      
        }
        
        $pattern = '/[^|]*:[^|]*:[^|]*/';

        if (preg_match($pattern, $fieldValidationMethods)) {
            throw new InvalidValidationMethodsException(
                'Invalid validation method format. Use only one colon (:).', $fieldValidationMethods
            );
        }
    }

	protected function getUniqueValidationMethods(string $fieldValidationMethods): array
	{
        $uniqueValidationMethods = [];
        
        foreach (explode('|', $fieldValidationMethods) as $fieldValidationMethod) {
        
            $validationMethod = explode(':', $fieldValidationMethod)[0];

            $uniqueValidationMethods[$validationMethod] = $fieldValidationMethod;
        }

        return array_values($uniqueValidationMethods);
	}
}
