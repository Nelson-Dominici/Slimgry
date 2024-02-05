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
        $fieldToValidate = 'number';
        $validationParts = ['int'];
        $customExceptionMessage = '';

        $this->intMethod = new IntMethod(
            $fieldToValidate, 
            $validationParts, 
            $customExceptionMessage
        );
    }

    public function testExecuteReturnsnullWhenTheRequestBodyFieldThatWillBeValidatedDoesNotExist(): void
    {
        $requestBody = ['thisFieldDoesNotExist' => 'nelsoncomer777@gmail.com'];

        $this->assertNull(
            $this->intMethod->execute($requestBody)
        );
    }

    public function testExecuteThrowsExceptionIfRequestBodyFieldValueIsNotAValidEmail(): void
    {
        $requestBody = ['number' => 'This is not an integer value'];

        $this->expectException(ValidationMethodException::class);
        $this->expectExceptionMessage('The number field does not have a integer value.');
        $this->expectExceptionCode(422);

        $this->intMethod->execute($requestBody);
    }
}
