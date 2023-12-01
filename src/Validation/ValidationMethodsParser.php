<?php 

declare(strict_types=1);

namespace NelsonDominici\Slimgry\Validation;

use NelsonDominici\Slimgry\Exceptions\InvalidValidationMethodsException;

 trait ValidationMethodsParser
{
    protected function checkFieldValidationMethods(mixed $validationMethods): void
	{        
        if (!is_string($validationMethods) || $validationMethods === '') {
            throw new InvalidValidationMethodsException(
                'Methods validation must be a string.' , $validationMethods
            );                      
        }
        
        $pattern = '/[^|]*:[^|]*:[^|]*/';

        if (preg_match($pattern, $validationMethods)) {
            throw new InvalidValidationMethodsException(
                'Invalid validation method format. Use only one colon (:).', $validationMethods
            );
        }
    }

	protected function getUniqueValidationMethods(string $validationMethods): array
	{
        $uniqueValidationMethods = [];
        
        foreach (explode('|', $validationMethods) as $validationMethod) {
        
            $validationMethodName = explode(':', $validationMethod)[0];

            $uniqueValidationMethods[$validationMethodName] = $validationMethod;
        }

        return array_values($uniqueValidationMethods);
	}
}
