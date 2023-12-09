<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod;

class ValidationMethodInstantiator
{    
    private ValidationMethodFinder $methodFinder;
    
    public function __construct()
    {
        $this->methodFinder = new ValidationMethodFinder();
    }

    public function getInstance(
        string $validationMethod,
        string $customExceptionMessage 
    ): Methods\ValidationMethod 
    {
        $validationMethodParts = explode(':', $validationMethod);
    
        $validationMethodName = $validationMethodParts[0];
        
        $validationMethodPath = $this->methodFinder->find($validationMethodName);

        return new $validationMethodPath(
            $validationMethodParts, 
            $customExceptionMessage
        );    
    }
}
