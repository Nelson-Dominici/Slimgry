<?php

declare(strict_types=1);

namespace tests\ValidationMethod\Methods;

use PHPUnit\Framework\TestCase;
use NelsonDominici\Slimgry\ValidationMethod\Methods\GteMethod;
use NelsonDominici\Slimgry\Exceptions\ValidationMethodException;

class GteMethodTest extends TestCase
{    
    private GteMethod $gteMethod;
    
    public function setUp(): void
    {
        $fieldToValidate = 'money';
        $validationParts = ['gte', '1000'];
        $customExceptionMessage = '';

        $this->gteMethod = new GteMethod(
            $fieldToValidate, 
            $validationParts, 
            $customExceptionMessage
        );
    }

    public function testExecuteReturnsNullIfTheRequestBodyFieldIsAboveTheMethodValue(): void
    {
        $this->assertNull(
            $this->gteMethod->execute(['number' => 5000])
        );
    }

    public function testExecuteReturnsNullIfTheRequestBodyFieldIsEqualsTheMethodValue(): void
    {
        $this->assertNull(
            $this->gteMethod->execute(['number' => 1000])
        );
    }

    public function testExecuteReturnsnullWhenTheRequestBodyFieldDoesNotExist(): void
    {
        $this->assertNull(
            $this->gteMethod->execute(['thisFieldIsNotExpected' => '1000.1'])
        );
    }

    public function testExecuteReturnsnullIfTheRequestBodyFieldIsNotNumeric(): void
    {
        $this->assertNull(
            $this->gteMethod->execute(['money' => 'Nelson'])
        );
    }
    
    public function testExecuteThrowsExceptionIfRequestBodyFieldIsNotAboveMethodValue(): void
    {
        $requestBody = ['money' => '100'];

        $this->expectException(ValidationMethodException::class);
        $this->expectExceptionMessage('The money field must be greater than or equal to 1000.');
        $this->expectExceptionCode(422);

        $this->gteMethod->execute($requestBody);
    }
}
