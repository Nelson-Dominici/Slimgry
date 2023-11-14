<?php

namespace NelsonDominici\Slimgry;

use NelsonDominici\Slimgry\Validations\{
    LengthValidation
};

abstract class Validator
{
    use LengthValidation;

	private function parsedFieldValidation(string $field, string $validations): array
	{
		if (!is_string($validations) || $validations === '') {
			
			$message = "The \"$field\" field must contain a valid validation";

			throw new \Exception($message, 500);
		}
                
        $parsedValdations = [];
 
        foreach (explode('|', $validations) as $validations) {
        
            $key = explode(':', $validations)[0];

            $parsedValdations[$key] = $validations;
        }

        return array_values($parsedValdations);
	}
	
	private function callValidation(array $parsedValdations): void
	{
        foreach($parsedValdations as $validation) {
        
            echo $validation; //incomplete.
  
        }
	}

	protected function validate(array $bodyValidations, ?array $requestBody): void
	{
		foreach ($bodyValidations as $field => $validations) {

            $parsedValdations = $this->parsedFieldValidation($field, $validations);

            $this->callValidation($parsedValdations);

		}
	}
}
