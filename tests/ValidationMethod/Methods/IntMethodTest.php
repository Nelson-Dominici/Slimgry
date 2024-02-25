<?php

declare(strict_types=1);

namespace tests\ValidationMethod\Methods;

use PHPUnit\Framework\TestCase;
use NelsonDominici\Slimgry\ValidationMethod\Methods\IntMethod;
use NelsonDominici\Slimgry\Exceptions\ValidationMethodException;

class IntMethodTest extends TestCase
{    
    private IntMethod $intMethod;
    
    public function setUp(): void
    {
        $validationParts = ['int'];
        $customExceptionMessage = '';

        $this->intMethod = new IntMethod(
            $validationParts, 
            $customExceptionMessage
        );
    }

    public function testExecuteReturnsNullIfRequestBodyFieldDoesNotExist(): void
    {
        $requestBodyField = [];
        $fieldToValidateParts = ['number'];

        $this->assertNull(
            $this->intMethod->execute(
                $requestBodyField,
                $fieldToValidateParts
            )
        );
    }
    
    public function testExecuteReturnsNullIfRequestBodyFieldIsAValidInt(): void
    {
        $requestBodyField = ['number' => 10];
        $fieldToValidateParts = ['number'];

        $this->assertNull(
            $this->intMethod->execute(
                $requestBodyField,
                $fieldToValidateParts
            )
        );
    }

    public function testExecuteThrowsExceptionIfRequestBodyFieldValueIsNotAValidInt(): void
    {
        $requestBodyField = ['money' => 10.1];
        $fieldToValidateParts = ['money'];

        $this->expectException(ValidationMethodException::class);
        $this->expectExceptionMessage('The money field must be a valid integer.');
        $this->expectExceptionCode(422);

        $this->intMethod->execute($requestBodyField, $fieldToValidateParts);
    }
}
