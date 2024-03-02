<?php

declare(strict_types=1);

namespace tests\ValidationMethod\Methods;

use PHPUnit\Framework\TestCase;
use NelsonDominici\Slimgry\ValidationMethod\Methods\IntegerMethod;
use NelsonDominici\Slimgry\Exceptions\ValidationMethodException;

class IntegerMethodTest extends TestCase
{    
    private IntegerMethod $integerMethod;
    
    public function setUp(): void
    {
        $validationParts = ['int'];
        $customExceptionMessage = '';

        $this->integerMethod = new IntegerMethod(
            $validationParts, 
            $customExceptionMessage
        );
    }
    
    public function testExecuteReturnsNullIfRequestBodyFieldCanBeNullable(): void
    {
        $requestBodyField = ['number' => null];
        $fieldToValidateParts = ['number'];
        $validationMethods = ['nullable'];

        $this->assertNull(
            $this->integerMethod->execute(
                $requestBodyField,
                $fieldToValidateParts,
                $validationMethods
            )
        );
    }

    public function testExecuteReturnsNullIfRequestBodyFieldDoesNotExist(): void
    {
        $requestBodyField = [];
        $fieldToValidateParts = ['number'];
        $validationMethods = [];

        $this->assertNull(
            $this->integerMethod->execute(
                $requestBodyField,
                $fieldToValidateParts,
                $validationMethods
            )
        );
    }
    
    public function testExecuteReturnsNullIfRequestBodyFieldIsAValidInt(): void
    {
        $requestBodyField = ['number' => 10];
        $fieldToValidateParts = ['number'];
        $validationMethods = [];

        $this->assertNull(
            $this->integerMethod->execute(
                $requestBodyField,
                $fieldToValidateParts,
                $validationMethods
            )
        );
    }

    public function testExecuteThrowsExceptionIfRequestBodyFieldValueIsNotAValidInt(): void
    {
        $requestBodyField = ['money' => 10.1];
        $fieldToValidateParts = ['money'];
        $validationMethods = [];

        $this->expectException(ValidationMethodException::class);
        $this->expectExceptionMessage('The money field must be a valid integer.');
        $this->expectExceptionCode(422);

        $this->integerMethod->execute(
            $requestBodyField, 
            $fieldToValidateParts,
            $validationMethods
        );
    }
}
