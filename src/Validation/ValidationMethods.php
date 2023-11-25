<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\Validation;

abstract class ValidationMethods
{
    protected const METHODS = [
        'max' => Methods\MaxMethod::class,
        'required' => Methods\RequiredMethod::class
    ];

    protected function checkValidationMethodExists(string $validationMethod): void
    {
        if (!array_key_exists($validationMethod, self::METHODS)) {
            throw new \Exception("Validation method '$validationMethod' does not exist.", 422);
        }    
    }
}
