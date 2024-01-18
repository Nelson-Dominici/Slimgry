<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\Exceptions;

class ValidationMethodSyntaxException extends \InvalidArgumentException
{
    public function __construct(
        string $message,
        private string $validationMethod
    ) {
        parent::__construct('Invalid validation method sintax. '.$message, 500);
    }

    function getValidationMethod()
    {
        return $this->validationMethod;
    }
} 
