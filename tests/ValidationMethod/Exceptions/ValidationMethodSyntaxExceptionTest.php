<?php

namespace tests\ValidationMethod\Exceptions;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use NelsonDominici\Slimgry\Exceptions\ValidationMethodSyntaxException;

class ValidationMethodSyntaxExceptionTest extends TestCase
{
    private ValidationMethodSyntaxException $exception;
    private string $validationMethod;
    private string $message;
    private int $statusCode;

    public function setUp(): void
    {
        $this->message = 'Validation method \"teste\" does not exist.';
        $this->validationMethod = 'teste';
        $this->statusCode = 404;
        
        $this->exception = new ValidationMethodSyntaxException(
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

    public function testExceptionMessageHasPrefix(): void
    {
        $prefix = 'Invalid validation method sintax. ';

        $this->assertSame($prefix . $this->message, $this->exception->getMessage());
    } 
}