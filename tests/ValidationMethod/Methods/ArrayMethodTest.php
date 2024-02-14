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
        $fieldToValidate = 'list';
        $validationParts = ['array'];
        $customExceptionMessage = '';

        $this->arrayMethod = new ArrayMethod(
            $fieldToValidate, 
            $validationParts, 
            $customExceptionMessage
        );
    }

    public function testExecuteReturnsnullWhenTheRequestBodyFieldDoesNotExist(): void
    {
        $this->assertNull(
            $this->arrayMethod->execute(['thisFieldIsNotTheExpectedField' => []])
        );
    }

    public function testExecuteThrowsExceptionIfRequestBodyFieldIsNotAValidArray(): void
    {
        $requestBody = ['list' => 'true'];

        $this->expectException(ValidationMethodException::class);
        $this->expectExceptionMessage('The list field is not a valid array.');
        $this->expectExceptionCode(422);

        $this->arrayMethod->execute($requestBody);
    }
}
