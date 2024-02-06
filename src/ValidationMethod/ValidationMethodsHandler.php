<?php 

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod;

use NelsonDominici\Slimgry\Exceptions\ValidationMethodSyntaxException;

class ValidationMethodsHandler
{
    public function checkMethodColon(string $validationMethod): void
	{        
        $colonCount = substr_count($validationMethod, ':');

        if ($colonCount === 1) {
            return;
        }

        $message = "The \"$validationMethod\" validation method cannot have more than one \":\".";

        throw new ValidationMethodSyntaxException(
            $message, 
            $validationMethod
        );
    }
    
	public function removeDuplicateMethods(string|array $validationMethods): array
	{
        $noRepetitions = [];
        
        if (is_string($validationMethods)) {
            $validationMethods = explode('|', $validationMethods);
        }

        foreach ($validationMethods as $validationMethod) {
        
            $validationMethodName = explode(':', $validationMethod)[0];

            $noRepetitions[$validationMethodName] = $validationMethod;
        }

        return array_values($noRepetitions);
	}
}
