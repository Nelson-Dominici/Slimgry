<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod;

use NelsonDominici\Slimgry\Exceptions\ValidationMethodSyntaxException;

class ValidationMethodFinder
{
    public function find(string $validationMethodName): string
    {
        $validationMethodPath = __NAMESPACE__.'\Methods\\'.ucfirst($validationMethodName)."Method";
        
        if (!class_exists($validationMethodPath) || $validationMethodName === 'validation') {

            $message = "Validation method \"$validationMethodName\" does not exist.";

            throw new ValidationMethodSyntaxException($message, $validationMethodName, 404);
        } 

        return $validationMethodPath;
    }
}