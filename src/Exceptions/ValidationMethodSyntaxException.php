<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\Exceptions;

class ValidationMethodSyntaxException extends \InvalidArgumentException
{
    public function __construct(
        string $message,
        private string $validationMethod,
        int $statusCode = 500
    ) {
        parent::__construct('Invalid validation method sintax. '.$message, $statusCode);
    }

    function getValidationMethod(): string
    {
        return $this->validationMethod;
    }
} 
