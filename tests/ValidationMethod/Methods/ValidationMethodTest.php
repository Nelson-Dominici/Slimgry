<?php

declare(strict_types=1);

namespace tests\ValidationMethod\Methods;

use PHPUnit\Framework\TestCase;
use NelsonDominici\Slimgry\Exceptions\ValidationMethodException;
use NelsonDominici\Slimgry\ValidationMethod\Methods\ValidationMethod;
use NelsonDominici\Slimgry\Exceptions\ValidationMethodSyntaxException;

class ValidationMethodTest extends TestCase
{   
    private string $defaultMessage;
    private ValidationMethod $validationMethodMock;
    private \ReflectionClass $validationMethodReflection;

    public function setUp(): void
    {
        $this->validationMethodMock = $this
            ->getMockBuilder(ValidationMethod::class)
            ->setConstructorArgs([
                ['max','invalidValue'], 
                'This is a custom exception message.'
            ])
            ->getMockForAbstractClass();

        $this->defaultMessage = 'Validation method default exception message.';

        $this->validationMethodReflection = new \ReflectionClass(
            ValidationMethod::class
        );
    } 

    public function testThrowsExceptionForNonNumericValidationMethodValue(): void
    {
        $getNumericValueMethod = $this->validationMethodReflection->getMethod(
            'getNumericValue'
        );

        $getNumericValueMethod->setAccessible(true);
        
        $this->expectException(ValidationMethodSyntaxException::class);
    
        $this->expectExceptionMessage(
            "The validation method \"max:invalidValue\" does not have a numeric value."
        );
    
        $this->expectExceptionCode(500);

        $getNumericValueMethod->invoke($this->validationMethodMock);    
    }

    public function testAssertAndThrowMethodReturnNullValueIfExpressionIsFalse(): void
    {
        $assertAndThrowMethod = $this->validationMethodReflection->getMethod(
            'assertAndThrow'
        );

        $assertAndThrowMethod->setAccessible(true);

        $nullValue = $assertAndThrowMethod->invoke(
            $this->validationMethodMock, 
            false, 
            $this->defaultMessage
        );

        $this->assertNull($nullValue);
    }

    public function testAssertAndThrowMethodThrowsExceptionWithCustomMessageIfExpressionIsTrue(): void
    {
        $assertAndThrowMethod = $this->validationMethodReflection->getMethod(
            'assertAndThrow'
        );

        $assertAndThrowMethod->setAccessible(true);

        $this->expectException(ValidationMethodException::class);
    
        $this->expectExceptionMessage('This is a custom exception message.');
    
        $this->expectExceptionCode(422);

        $assertAndThrowMethod->invoke(
            $this->validationMethodMock, 
            true, 
            $this->defaultMessage
        );
    }

    public function testThrowExceptionMethodThrowsExceptionWithCustomMessage(): void
    {
        $throwExceptionMethod = $this->validationMethodReflection->getMethod(
            'throwException'
        );

        $throwExceptionMethod->setAccessible(true);

        $this->expectException(ValidationMethodException::class);
    
        $this->expectExceptionMessage('This is a custom exception message.');
    
        $this->expectExceptionCode(422);

        $throwExceptionMethod->invoke(
            $this->validationMethodMock, 
            $this->defaultMessage
        );
    }
}