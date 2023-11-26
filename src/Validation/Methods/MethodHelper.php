<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\Validation\Methods;

abstract class MethodHelper
{
    public function __construct(
        protected string $fieldName, 
        protected array $requestBody, 
        private array $validationParts,
        private string $customExceptionMessage
    ) {}

    protected function validationMethodValue(): int
    {
        $validationMethod = $this->validationParts[0];
    
        if (
            !array_key_exists(1, $this->validationParts) || 
            !ctype_digit($this->validationParts[1])
        ) {
            
            throw new \Exception(
                "The validation method '$validationMethod' does not have a numeric value", 422);
        }
        
        $numericMethodValue = intval($this->validationParts[1]);
        
        return $numericMethodValue;
    }

    protected function throwException(string $exceptionMessage, int $statuscode = 400): void
    {    
        $exceptionMessage = $this->customExceptionMessage ?: $exceptionMessage;

        throw new \Exception($exceptionMessage, $statuscode);        
    }

    protected function assertAndThrow(bool $expression, string $exceptionMessage, int $statuscode = 400): void
    {      
        if ($expression) {
            $exceptionMessage = $this->customExceptionMessage ?: $exceptionMessage;

            throw new \Exception($exceptionMessage, $statuscode);
        }
    }
}
