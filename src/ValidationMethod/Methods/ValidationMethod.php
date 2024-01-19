<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod\Methods;

use NelsonDominici\Slimgry\Exceptions\ValidationMethodSyntaxException;
use NelsonDominici\Slimgry\Exceptions\ValidationMethodException;

abstract class ValidationMethod
{    
    public function __construct(
        protected string $fieldToValidate,
        protected array $validationParts,
        private string $customExceptionMessage
    ) {}

    protected function getNumericValue(): int
    {
        $validationMethodName = $this->validationParts[0];
    
        if (
            !array_key_exists(1, $this->validationParts) || 
            !ctype_digit($this->validationParts[1])
        ) {
            $validationMethod = $validationMethodName.':'.$this->validationParts[1];

            $message = "The validation method \"$validationMethod\" does not have a numeric value.";
            
            throw new ValidationMethodSyntaxException(
                $message,
                $validationMethodName
            );
        }
        
        $numericMethodValue = intval($this->validationParts[1]);
        
        return $numericMethodValue;
    }

    protected function throwException(string $exceptionMessage): void
    {    
        $exceptionMessage = $this->customExceptionMessage ?: $exceptionMessage;

        throw new ValidationMethodException($exceptionMessage, $this->validationParts[0]);        
    }

    protected function assertAndThrow(bool $expression, string $exceptionMessage): null
    {      
        if (!$expression) {
            return null;
        }

        $exceptionMessage = $this->customExceptionMessage ?: $exceptionMessage;

        throw new ValidationMethodException($exceptionMessage, $this->validationParts[0]);
    }
    
    abstract protected function execute(array $requestBody, array $validatedRequestBody): ?array;
}