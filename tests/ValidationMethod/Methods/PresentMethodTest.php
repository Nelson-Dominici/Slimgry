<?php

declare(strict_types=1);

namespace tests\ValidationMethod\Methods;

use PHPUnit\Framework\TestCase;
use NelsonDominici\Slimgry\Exceptions\ValidationMethodException;
use NelsonDominici\Slimgry\ValidationMethod\Methods\PresentMethod;

class PresentMethodTest extends TestCase
{
    private PresentMethod $presentMethod;
    
    public function setUp(): void
    {
        $fieldToValidate = 'name';
        $validationParts = ['present'];
        $customExceptionMessage = '';

        $this->presentMethod = new PresentMethod(
            $fieldToValidate, 
            $validationParts, 
            $customExceptionMessage
        );
    }
    public function testExecuteReturnsNullIfTheFieldExistsInRequestBody(): void
    {
        $requestBody = ['name' => 'Nelson'];

        $this->assertNull(
            $this->presentMethod->execute($requestBody)
        );
    }
    
    public function testExecuteReturnsNullIfTheRequestBodyFieldDoesNotExist(): void
    {
        $requestBody = ['thisFieldDoesNotExist' => 'Nelson'];

        $this->expectException(ValidationMethodException::class);
        $this->expectExceptionMessage('The name field must be present.');
        $this->expectExceptionCode(422);

        $this->presentMethod->execute($requestBody);
    }
}
