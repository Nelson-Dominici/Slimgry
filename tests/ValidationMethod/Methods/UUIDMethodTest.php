<?php

declare(strict_types=1);

namespace tests\ValidationMethod\Methods;

use PHPUnit\Framework\TestCase;
use NelsonDominici\Slimgry\ValidationMethod\Methods\UUIDMethod;
use NelsonDominici\Slimgry\Exceptions\ValidationMethodException;

class UUIDMethodTest extends TestCase
{    
    private UUIDMethod $uuidMethod;
    
    public function setUp(): void
    {
        $validationParts = ['uuid'];
        $customExceptionMessage = '';

        $this->uuidMethod = new UUIDMethod(
            $validationParts, 
            $customExceptionMessage
        );
    }
    public function testExecuteReturnsNullIfRequestBodyFieldIsAValidUUID(): void
    {
        $requestBodyField = ['uuid' => '550e8400-e29b-41d4-a716-446655440000'];
        $fieldToValidateParts = ['uuid'];

        $this->assertNull(
            $this->uuidMethod->execute(
                $requestBodyField,
                $fieldToValidateParts
            )
        );
    }
    
    public function testExecuteReturnsNullIfRequestBodyFieldDoesNotExist(): void
    {
        $requestBodyField = [];
        $fieldToValidateParts = ['uuid'];

        $this->assertNull(
            $this->uuidMethod->execute(
                $requestBodyField,
                $fieldToValidateParts
            )
        );
    }

    public function testExecuteThrowsExceptionIfRequestBodyFieldVIsNotAValidUuid(): void
    {
        $requestBodyField = ['uuid' => '550e8400-e29b-41d4-a716-446655440000sad'];
        $fieldToValidateParts = ['users','nelson','uuid'];

        $this->expectException(ValidationMethodException::class);
        $this->expectExceptionMessage('The uuid field must be a valid uuid.');
        $this->expectExceptionCode(422);

        $this->uuidMethod->execute($requestBodyField, $fieldToValidateParts);
    }
}
