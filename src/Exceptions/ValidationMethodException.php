<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\Exceptions;

class ValidationMethodException extends \InvalidArgumentException
{
    public function __construct(
        string $message,
        private string $validationMethod
    ) {
        parent::__construct($message, 422);
    }

    function getValidationMethod(): string
    {
        return $this->validationMethod;
    }
} 
