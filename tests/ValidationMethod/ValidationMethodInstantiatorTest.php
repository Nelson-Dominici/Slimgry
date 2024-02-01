<?php

declare(strict_types=1);

namespace tests\ValidationMethod;

use PHPUnit\Framework\TestCase;

use NelsonDominici\Slimgry\ValidationMethod\{
    ValidationMethodFinder,
    ValidationMethodInstantiator,
    CustomExceptionMessageProvider
};

use NelsonDominici\Slimgry\ValidationMethod\Methods\{
    StringMethod,
    ValidationMethod
};

class ValidationMethodInstantiatorTest extends TestCase
{    
    public function testMustReturnTheInstanceOfAValidationMethod(): void
    {
        $exampleFieldToValidate = 'name';
        $exampleValidationMethod = 'string';
        
        $validationMethodFinder = $this->createMock(
            ValidationMethodFinder::class
        );

        $customExceptionMessageProvider = $this->createMock(
            CustomExceptionMessageProvider::class
        );

        $validationMethodFinder
            ->method('find')
            ->willReturn(StringMethod::class);

        $customExceptionMessageProvider
            ->method('getCustomMessage')
            ->willReturn('');

        $validationMethodInstantiator = new ValidationMethodInstantiator(
            $validationMethodFinder,
            $customExceptionMessageProvider
        );

        $validationMethodInstance = $validationMethodInstantiator->getInstance(
            $exampleFieldToValidate, $exampleValidationMethod
        );

        $this->assertInstanceOf(ValidationMethod::class, $validationMethodInstance);
    }
}
