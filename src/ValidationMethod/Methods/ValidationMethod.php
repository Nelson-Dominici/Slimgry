<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod\Methods;

abstract class ValidationMethod
{    
    public function __construct(
        public array $validationParts,
        private string $customExceptionMessage
    ) {}

    protected function getNumericValue(): int
    {
        $validationMethodName = $this->validationParts[0];
    
        if (
            !array_key_exists(1, $this->validationParts) || 
            !ctype_digit($this->validationParts[1])
        ) {
            
            throw new \Exception(
                "The validation method '$validationMethodName' does not have a numeric value", 422);
        }
        
        $numericMethodValue = intval($this->validationParts[1]);
        
        return $numericMethodValue;
    }

    protected function throwException(string $exceptionMessage): void
    {    
        $exceptionMessage = $this->customExceptionMessage ?: $exceptionMessage;

        throw new \Exception($exceptionMessage, 422);        
    }

    protected function assertAndThrow(bool $expression, string $exceptionMessage): void
    {      
        if ($expression) {
            $exceptionMessage = $this->customExceptionMessage ?: $exceptionMessage;

            throw new \Exception($exceptionMessage, 422);
        }
    }
    
    // abstract protected function execute(): ?array;
}
