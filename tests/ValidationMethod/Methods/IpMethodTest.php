<?php

declare(strict_types=1);

namespace tests\ValidationMethod\Methods;

use PHPUnit\Framework\TestCase;
use NelsonDominici\Slimgry\ValidationMethod\Methods\IpMethod;
use NelsonDominici\Slimgry\Exceptions\ValidationMethodException;

class IpMethodTest extends TestCase
{    
    private IpMethod $ipMethod;
    
    public function setUp(): void
    {
        $validationParts = ['email'];
        $customExceptionMessage = '';

        $this->ipMethod = new IpMethod(
            $validationParts, 
            $customExceptionMessage
        );
    }

    public function testExecuteReturnsNullIfRequestBodyFieldDoesNotExist(): void
    {
        $requestBodyField = [];
        $validationMethods = [];
        $fieldToValidateParts = ['adm'];

        $this->assertNull(
            $this->ipMethod->execute(
                $requestBodyField,
                $fieldToValidateParts,
                $validationMethods
            )
        );
    }

    public function testExecuteReturnsNullIfRequestBodyFieldCanBeNullable(): void
    {
        $requestBodyField = ['ip' => null];
        $fieldToValidateParts = ['ip'];
        $validationMethods = ['nullable'];

        $this->assertNull(
            $this->ipMethod->execute(
                $requestBodyField,
                $fieldToValidateParts,
                $validationMethods
            )
        );
    }

    public function testExecuteReturnsNullIfRequestBodyFieldIsAValidIp(): void
    {
        $requestBodyField = ['ip' => '192.168.0.0'];
        $fieldToValidateParts = ['ip'];
        $validationMethods = [];
        
        $this->assertNull(
            $this->ipMethod->execute(
                $requestBodyField,
                $fieldToValidateParts,
                $validationMethods
            )
        );
    }

    public function testExecuteThrowsExceptionIfRequestBodyFieldIsNotAValidIp(): void
    {
        $validationMethods = [];
        $requestBodyField = ['ip' => 'lol'];
        $fieldToValidateParts = ['ip'];

        $this->expectException(ValidationMethodException::class);
        $this->expectExceptionMessage('The ip field must be a valid IP address.');
        $this->expectExceptionCode(422);

        $this->ipMethod->execute(
            $requestBodyField, 
            $fieldToValidateParts,
            $validationMethods
        );
    }
}
