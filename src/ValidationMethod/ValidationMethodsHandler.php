<?php 

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod;

use NelsonDominici\Slimgry\Exceptions\InvalidValidationMethodsException;

class ValidationMethodsHandler
{
    public function handle(mixed $validationMethods): array
    {
        $this->ensureString($validationMethods);
        $this->checkValidationMethodsFormat($validationMethods);
        
        return $this->getUniqueValidationMethods($validationMethods);
    }

    private function ensureString(mixed $validationMethods): void
	{        
        $message = 'Methods validation must be a string.';
        
        if (!is_string($validationMethods) || $validationMethods === '') {
            throw new InvalidValidationMethodsException($message, $validationMethods);                      
        }
    }

    private function checkValidationMethodsFormat(mixed $validationMethods): void
	{        
        $pattern = '/[^|]*:[^|]*:[^|]*/';
    
        $message = 'Invalid validation methods format. Use only one colon (:).';
        
        if (preg_match($pattern, $validationMethods)) {
            throw new InvalidValidationMethodsException($message, $validationMethods);
        }
    }
    
	private function getUniqueValidationMethods(string $validationMethods): array
	{
        $uniqueValidationMethods = [];
        
        foreach (explode('|', $validationMethods) as $validationMethod) {
        
            $validationMethodName = explode(':', $validationMethod)[0];

            $uniqueValidationMethods[$validationMethodName] = $validationMethod;
        }

        return array_values($uniqueValidationMethods);
	}
}
