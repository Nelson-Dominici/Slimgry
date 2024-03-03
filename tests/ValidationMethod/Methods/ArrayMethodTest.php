<?php

declare(strict_types=1);

namespace tests\ValidationMethod\Methods;

use PHPUnit\Framework\TestCase;
use NelsonDominici\Slimgry\Exceptions\ValidationMethodException;
use NelsonDominici\Slimgry\ValidationMethod\Methods\ArrayMethod;

class ArrayMethodTest extends TestCase
{    
    private ArrayMethod $arrayMethod;
    
    public function setUp(): void
    {
        $validationParts = ['array'];
        $customExceptionMessage = '';

        $this->arrayMethod = new ArrayMethod(
            $validationParts, 
            $customExceptionMessage
        );
    }

    public function testExecuteReturnsNullIfRequestBodyFieldCanBeNullable(): void
    {
        $requestBodyField = ['list' => null];
        $fieldToValidateParts = ['list'];
        $validationMethods = ['nullable'];

        $this->assertNull(
            $this->arrayMethod->execute(
                $requestBodyField,
                $fieldToValidateParts,
                $validationMethods
            )
        );
    }

    public function testExecuteReturnsNullWhenTheRequestBodyFieldDoesNotExist(): void
    {
        $validationMethods = [];
        $requestBodyField = [];
        $fieldToValidateParts = ['list'];

        $this->assertNull(
            $this->arrayMethod->execute(
                $requestBodyField,
                $fieldToValidateParts,
                $validationMethods
            )
        );
    }

    public function testExecuteThrowsExceptionIfRequestBodyFieldIsNotAValidArray(): void
    {
        $requestBodyField = ['list' => null];
        $fieldToValidateParts = ['list'];
        $validationMethods = [];

        $this->expectException(ValidationMethodException::class);
        $this->expectExceptionMessage('The list field must be a valid array.');
        $this->expectExceptionCode(422);

        $this->arrayMethod->execute(
            $requestBodyField, 
            $fieldToValidateParts,
            $validationMethods
        );
    }
}
