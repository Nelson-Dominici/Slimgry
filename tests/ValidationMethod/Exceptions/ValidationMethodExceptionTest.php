<?php

namespace tests\ValidationMethod\Exceptions;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use NelsonDominici\Slimgry\Exceptions\ValidationMethodException;

class ValidationMethodExceptionTest extends TestCase
{
    private ValidationMethodException $exception;
    private string $validationMethod;
    private string $message;
    private int $statusCode;

    public function setUp(): void
    {
        $this->message = 'The name field must be a string.';
        $this->validationMethod = 'string';
        $this->statusCode = 422;
        
        $this->exception = new ValidationMethodException(
            $this->message, 
            $this->validationMethod,
            $this->statusCode
        );                
    }

    public function testExceptionIsAInstanceOfInvalidArgumentException(): void
    {
        $this->assertInstanceOf(
            InvalidArgumentException::class,
            $this->exception
        );
    } 

    public function testGetValidationMethodReturnsValidationMethod(): void
    {
        $this->assertSame(
            $this->validationMethod, 
            $this->exception->getValidationMethod()
        );
    }
}