<?php 

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod;

use NelsonDominici\Slimgry\Exceptions\ValidationMethodSintaxException;

class ValidationMethodsHandler
{
    public function handle(mixed $validationMethods): array
    {
        $this->checkKeyValueValidationMethodsFormat($validationMethods);
        
        return $this->removeRepetitions($validationMethods);
    }

    private function checkKeyValueValidationMethodsFormat(string $validationMethods): void
	{        
        $pattern = '/[^|]*:[^|]*:[^|]*/';

        if (preg_match($pattern, $validationMethods, $matches, PREG_OFFSET_CAPTURE)) {

            $validationMethod = $matches[0][0];

            $message = 'The '.$validationMethod.' validation method cannot have more than ":".';

            throw new ValidationMethodSintaxException($message, $validationMethod);
        }
    }
    
	private function removeRepetitions(string $validationMethods): array
	{
        $uniqueValidationMethods = [];
        
        foreach (explode('|', $validationMethods) as $validationMethod) {
        
            $validationMethodName = explode(':', $validationMethod)[0];

            $uniqueValidationMethods[$validationMethodName] = $validationMethod;
        }

        return array_values($uniqueValidationMethods);
	}
}
