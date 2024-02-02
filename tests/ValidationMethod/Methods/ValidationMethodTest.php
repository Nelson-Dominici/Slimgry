<?php

declare(strict_types=1);

namespace tests\ValidationMethod\Methods;

use PHPUnit\Framework\TestCase;
use NelsonDominici\Slimgry\Exceptions\ValidationMethodException;
use NelsonDominici\Slimgry\ValidationMethod\Methods\ValidationMethod;
use NelsonDominici\Slimgry\Exceptions\ValidationMethodSyntaxException;

class ValidationMethodTest extends TestCase
{   
    private ValidationMethod $validationMethodMock;
    private \ReflectionClass $validationMethodReflection;

    public function setUp(): void
    {
        $this->validationMethodMock = $this
            ->getMockBuilder(ValidationMethod::class)
            ->setConstructorArgs([
                'name', 
                ['max','test'], 
                'This is a custom exception message.'
            ])
            ->getMockForAbstractClass();

        $this->validationMethodReflection = new \ReflectionClass(
            ValidationMethod::class
        );
    } 

    public function testThrowsExceptionForNonNumericKeyValueValidationMethodValue(): void
    {
        $getNumericValueMethod = $this->validationMethodReflection->getMethod(
            'getNumericValue'
        );

        $getNumericValueMethod->setAccessible(true);
        
        $this->expectException(ValidationMethodSyntaxException::class);
    
        $this->expectExceptionMessage(
            "The validation method \"max:test\" does not have a numeric value."
        );
    
        $this->expectExceptionCode(500);

        $getNumericValueMethod->invoke($this->validationMethodMock);    
    }

    public function testAssertAndThrowMethodReturnNullValueIfExpressionIsFalse(): void
    {
        $defaultMessage = 'This is a default exception message.';
        
        $assertAndThrowMethod = $this->validationMethodReflection->getMethod(
            'assertAndThrow'
        );

        $assertAndThrowMethod->setAccessible(true);

        $nullValue = $assertAndThrowMethod->invoke(
            $this->validationMethodMock, 
            false, 
            $defaultMessage
        );

        $this->assertNull($nullValue);
    }

    public function testAssertAndThrowMethodThrowsExceptionWithCustomMessageIfExpressionIsTrue(): void
    {
        $defaultMessage = 'This is a default exception message.';
        
        $assertAndThrowMethod = $this->validationMethodReflection->getMethod(
            'assertAndThrow'
        );

        $assertAndThrowMethod->setAccessible(true);

        $this->expectException(ValidationMethodException::class);
    
        $this->expectExceptionMessage('This is a custom exception message.');
    
        $this->expectExceptionCode(422);

       $assertAndThrowMethod->invoke($this->validationMethodMock, true, $defaultMessage);
    }

    public function testThrowExceptionMethodThrowsExceptionWithCustomMessage(): void
    {
        $defaultMessage = 'This is a default exception message.';

        $throwExceptionMethod = $this->validationMethodReflection->getMethod(
            'throwException'
        );

        $throwExceptionMethod->setAccessible(true);

        $this->expectException(ValidationMethodException::class);
    
        $this->expectExceptionMessage('This is a custom exception message.');
    
        $this->expectExceptionCode(422);

       $throwExceptionMethod->invoke($this->validationMethodMock, $defaultMessage);
    }
}