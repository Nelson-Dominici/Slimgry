<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod;

class ValidationMethodFinder
{
    public function find(string $validationMethodName): string
    {
        $validationMethodPath = __NAMESPACE__.'\Methods\\'.ucfirst($validationMethodName)."Method";
        
        if (class_exists($validationMethodPath)) {
            return $validationMethodPath;
        } 
        
        throw new \Exception(
            "Validation method '$validationMethodName' does not exist.", 422
        );
    }
}