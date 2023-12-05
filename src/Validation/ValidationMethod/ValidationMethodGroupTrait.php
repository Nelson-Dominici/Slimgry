<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\Validation\ValidationMethod;

trait ValidationMethodGroupTrait
{
    private const METHODS = [
        'min' => Methods\MinMethod::class,
        'trim' => Methods\TrimMethod::class,
        'max' => Methods\MaxMethod::class,
        'string' => Methods\StringMethod::class,
        'required' => Methods\RequiredMethod::class
    ];
      
    private function getValidationMethod(string $validationMethodName): string
    {
        if (!isset(self::METHODS[$validationMethodName])) {
            throw new \Exception(
                "Validation method '$validationMethodName' does not exist.", 422
            );
        }
        
        return self::METHODS[$validationMethodName];
    }
}
