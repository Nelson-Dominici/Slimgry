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
        $fieldToValidate = 'uuid';
        $validationParts = ['uuid'];
        $customExceptionMessage = '';

        $this->uuidMethod = new UUIDMethod(
            $fieldToValidate, 
            $validationParts, 
            $customExceptionMessage
        );
    }
    public function testExecuteReturnsnullWhenTheRequestBodyFieldIsAValidUUID(): void
    {
        $requestBody = ['uuid' => '550e8400-e29b-41d4-a716-446655440000'];
        
        $this->assertNull(
            $this->uuidMethod->execute($requestBody)
        );
    }
    
    public function testExecuteReturnsnullWhenTheRequestBodyFieldDoesNotExist(): void
    {
        $requestBody = ['thisFieldDoesNotExist' => '02020491'];
        
        $this->assertNull(
            $this->uuidMethod->execute($requestBody)
        );
    }

    public function testExecuteThrowsExceptionIfRequestBodyFieldValueIsNotAValidEmail(): void
    {
        $requestBody = ['uuid' => 'This is an invalid uuid'];

        $this->expectException(ValidationMethodException::class);
        $this->expectExceptionMessage('The uuid field is not a valid uuid.');
        $this->expectExceptionCode(422);

        $this->uuidMethod->execute($requestBody);
    }
}
