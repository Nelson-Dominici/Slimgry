<?php 

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod;

use NelsonDominici\Slimgry\Exceptions\ValidationMethodSyntaxException;

class ValidationMethodsHandler
{
    public function checkKeyValueValidationMethodsFormat(string $validationMethod): void
	{        
        $colonCount = substr_count($validationMethod, ':');

        if ($colonCount === 1) {
            return;
        }

        $message = "The \"$validationMethod\" validation method cannot have more than \":\".";

        throw new ValidationMethodSyntaxException(
            $message, 
            $validationMethod
        );
    }
    
	public function removeRepetitions(string|array $validationMethods): array
	{
        $uniqueValidationMethods = [];
        
        if (is_string($validationMethods)) {
            $validationMethods = explode('|', $validationMethods);
        }

        foreach ($validationMethods as $validationMethod) {
        
            $validationMethodName = explode(':', $validationMethod)[0];

            $uniqueValidationMethods[$validationMethodName] = $validationMethod;
        }

        return array_values($uniqueValidationMethods);
	}
}
