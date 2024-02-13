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
        $fieldToValidate = 'number';
        $validationParts = ['numeric'];
        $customExceptionMessage = '';

        $this->numericMethod = new NumericMethod(
            $fieldToValidate, 
            $validationParts, 
            $customExceptionMessage
        );
    }

    public function testExecuteThrowsExceptionIfRequestBodyFieldValueIsNotNumeric(): void
    {
        $requestBody = ['number' => 'This is not a numerical value'];

        $this->expectException(ValidationMethodException::class);
        $this->expectExceptionMessage('The number field does not have a numeric value.');
        $this->expectExceptionCode(422);

        $this->numericMethod->execute($requestBody);
    }
    
    public function testExecuteReturnsNullIfRequestBodyFieldIsAValidNumeric(): void
    {
        $this->assertNull(
            $this->numericMethod->execute(['number' => 1])
        );
    }

    public function testExecuteReturnsnullWhenTheRequestBodyFieldDoesNotExist(): void
    {
        $this->assertNull(
            $this->numericMethod->execute(['thisFieldDoesNotExist' => 'nelsoncomer777@gmail.com'])
        );
    }
}
