<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod;

class ValidationMethodInstantiator
{    
    public function __construct(
        private ValidationMethodFinder $methodFinder,
        private CustomExceptionMessageProvider $messageProvider
    ){}

    public function getInstance(string $fieldToValidate, string $validationMethod): Methods\ValidationMethod 
    {
        $validationMethodParts = explode(':', $validationMethod);
    
        $validationMethodName = $validationMethodParts[0];
    
        $customExceptionMessage = $this->messageProvider->getCustomMessage(
            $fieldToValidate,
            $validationMethod
        );
        
        $validationMethodPath = $this->methodFinder->find($validationMethodName);

        return new $validationMethodPath(
            $fieldToValidate,
            $validationMethodParts, 
            $customExceptionMessage
        );    
    }
}
