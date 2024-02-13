<?php

declare(strict_types=1);

namespace tests\ValidationMethod\Methods;

use PHPUnit\Framework\TestCase;
use NelsonDominici\Slimgry\Exceptions\ValidationMethodException;
use NelsonDominici\Slimgry\ValidationMethod\Methods\StringMethod;

class StringMethodTest extends TestCase
{
    private StringMethod $stringMethod;
    
    public function setUp(): void
    {
        $fieldToValidate = 'name';
        $validationParts = ['string'];
        $customExceptionMessage = '';

        $this->stringMethod = new StringMethod(
            $fieldToValidate, 
            $validationParts, 
            $customExceptionMessage
        );
    }
    
    public function testExecuteReturnsNullIfRequestBodyFieldIsAValidString(): void
    {
        $this->assertNull(
            $this->stringMethod->execute(['name' => 'Nelson Dominici'])
        );
    }

    public function testExecuteMethodReturnsNullIfFieldToValidateDoesNotExist(): void
    {
        $this->assertNull(
            $this->stringMethod->execute(['ThisFieldDoesNotExist' => 'Nelson'])
        );
    }

    public function testExecuteMethodThrowsExceptionIfFieldToValidateIsNotAString(): void
    {
        $this->expectException(ValidationMethodException::class);
        $this->expectExceptionMessage('The name field must be a string.');
        $this->expectExceptionCode(422);

        $this->stringMethod->execute(['name' => 123]);
    }
}
