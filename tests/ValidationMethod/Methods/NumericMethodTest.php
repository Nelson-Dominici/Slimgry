<?php

declare(strict_types=1);

namespace tests\ValidationMethod\Methods;

use PHPUnit\Framework\TestCase;
use NelsonDominici\Slimgry\ValidationMethod\Methods\NumericMethod;
use NelsonDominici\Slimgry\Exceptions\ValidationMethodException;

class NumericMethodTest extends TestCase
{    
    private NumericMethod $numericMethod;
    
    public function setUp(): void
    {
        $validationParts = ['numeric'];
        $customExceptionMessage = '';

        $this->numericMethod = new NumericMethod(
            $validationParts, 
            $customExceptionMessage
        );
    }

    public function testExecuteThrowsExceptionIfRequestBodyFieldIsNotNumeric(): void
    {
        $requestBodyField = ['number' => null];
        $fieldToValidateParts = ['number'];

        $this->expectException(ValidationMethodException::class);
        $this->expectExceptionMessage('The number field must have a numeric value.');
        $this->expectExceptionCode(422);

        $this->numericMethod->execute($requestBodyField, $fieldToValidateParts);
    }

    public function testExecuteReturnsNullIfRequestBodyFieldIsNumeric(): void
    {
        $requestBodyField = ['number' => '10'];
        $fieldToValidateParts = ['number'];

        $this->assertNull(
            $this->numericMethod->execute(
                $requestBodyField,
                $fieldToValidateParts
            )
        );
    }

    public function testExecuteReturnsNullIfRequestBodyFieldDoesNotExist(): void
    {
        $requestBodyField = [];
        $fieldToValidateParts = ['number'];

        $this->assertNull(
            $this->numericMethod->execute(
                $requestBodyField,
                $fieldToValidateParts
            )
        );
    }
}
