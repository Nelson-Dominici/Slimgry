<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod;

class ValidationMethodInstantiator
{    
    public function __construct(
        private ValidationMethodFinder $methodFinder,
        private CustomExceptionMessageProvider $messageProvider
    ){}

    public function getInstance(array $fieldToValidateParts, string $validationMethod): Methods\ValidationMethod 
    {
        $validationMethodParts = explode(':', $validationMethod);
    
        $validationMethodKey = $validationMethodParts[0];
    
        $customExceptionMessage = $this->messageProvider->getMessage(
            $fieldToValidateParts,
            $validationMethodKey
        );
        
        $validationMethodPath = $this->methodFinder->find($validationMethodKey);

        return new $validationMethodPath(
            $validationMethodParts, 
            $customExceptionMessage
        );    
    }
}
