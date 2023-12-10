<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod;

class ValidationMethodInstantiator
{    
    private ValidationMethodFinder $methodFinder;
    private CustomExceptionMessageProvider $messageProvider;

    public function __construct()
    {
        $this->methodFinder = new ValidationMethodFinder();
        $this->messageProvider = new CustomExceptionMessageProvider();
    }

    public function getInstance(
        string $fieldToValidate,
        string $validationMethod,
        array $customExceptionMessages
    ): Methods\ValidationMethod 
    {
        $validationMethodParts = explode(':', $validationMethod);
    
        $validationMethodName = $validationMethodParts[0];
    
        $customExceptionMessage = $this->messageProvider->getCustomMessage(
            $fieldToValidate,
            $validationMethod,
            $customExceptionMessages
        );
        
        $validationMethodPath = $this->methodFinder->find($validationMethodName);

        return new $validationMethodPath(
            $validationMethodParts, 
            $customExceptionMessage
        );    
    }
}
