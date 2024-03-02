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
        $validationParts = ['string'];
        $customExceptionMessage = '';

        $this->stringMethod = new StringMethod(
            $validationParts, 
            $customExceptionMessage
        );
    }
    
    public function testExecuteReturnsNullIfRequestBodyFieldIsAValidString(): void
    {
        $requestBodyField = ['name' => 'Nelson'];
        $fieldToValidateParts = ['name'];
        $validationMethods = [];

        $this->assertNull(
            $this->stringMethod->execute(
                $requestBodyField,
                $fieldToValidateParts,
                $validationMethods
            )
        );
    }

    public function testExecuteReturnsNullIfRequestBodyFieldDoesNotExist(): void
    {
        $requestBodyField = [];
        $fieldToValidateParts = ['name'];
        $validationMethods = [];

        $this->assertNull(
            $this->stringMethod->execute(
                $requestBodyField,
                $fieldToValidateParts,
                $validationMethods
            )
        );
    }

    public function testExecuteMethodThrowsExceptionIfFieldToValidateIsNotAString(): void
    {
        $requestBodyField = ['name' => 10];
        $fieldToValidateParts = ['users','nelson','name'];
        $validationMethods = [];

        $this->expectException(ValidationMethodException::class);
        $this->expectExceptionMessage('The users.nelson.name field must be a string.');
        $this->expectExceptionCode(422);

        $this->stringMethod->execute(
            $requestBodyField, 
            $fieldToValidateParts,
            $validationMethods
        );
    }
}
