<?php

declare(strict_types=1);

namespace tests\ValidationMethod\Methods;

use PHPUnit\Framework\TestCase;
use NelsonDominici\Slimgry\ValidationMethod\Methods\GtMethod;
use NelsonDominici\Slimgry\Exceptions\ValidationMethodException;

class GtMethodTest extends TestCase
{    
    private GtMethod $gtMethod;
    
    public function setUp(): void
    {
        $fieldToValidate = 'money';
        $validationParts = ['gt', '1000'];
        $customExceptionMessage = '';

        $this->gtMethod = new GtMethod(
            $fieldToValidate, 
            $validationParts, 
            $customExceptionMessage
        );
    }

    public function testExecuteReturnsNullIfTheRequestBodyFieldIsAboveTheMethodValue(): void
    {
        $this->assertNull(
            $this->gtMethod->execute(['number' => 5000])
        );
    }

    public function testExecuteReturnsnullWhenTheRequestBodyFieldDoesNotExist(): void
    {
        $this->assertNull(
            $this->gtMethod->execute(['thisFieldIsNotExpected' => '1000.1'])
        );
    }

    public function testExecuteReturnsnullIfTheRequestBodyFieldIsNotNumeric(): void
    {
        $this->assertNull(
            $this->gtMethod->execute(['money' => 'Nelson'])
        );
    }
    
    public function testExecuteThrowsExceptionIfRequestBodyFieldIsNotAboveMethodValue(): void
    {
        $requestBody = ['money' => '100'];

        $this->expectException(ValidationMethodException::class);
        $this->expectExceptionMessage('The money field must be greater than 1000.');
        $this->expectExceptionCode(422);

        $this->gtMethod->execute($requestBody);
    }
}
