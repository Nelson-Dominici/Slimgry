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
        $validationParts = ['present'];
        $customExceptionMessage = '';
        $validationMethods = [];

        $this->presentMethod = new PresentMethod(
            $validationParts, 
            $customExceptionMessage
        );
    }

    public function testExecuteReturnsNullIfTheRequestBodyFieldIsPresent(): void
    {
        $requestBodyField = ['name' => []];
        $fieldToValidateParts = ['name'];
        $validationMethods = [];

        $this->assertNull(
            $this->presentMethod->execute(
                $requestBodyField,
                $fieldToValidateParts,
                $validationMethods
            )
        );
    }
    
    public function testExecuteThrowsExceptionIfTheRequestBodyFieldIsNotPresent(): void
    {
        $requestBodyField = [];
        $fieldToValidateParts = ['name'];
        $validationMethods = [];

        $this->expectException(ValidationMethodException::class);
        $this->expectExceptionMessage('The name field must be present.');
        $this->expectExceptionCode(422);

        $this->presentMethod->execute(
            $requestBodyField, 
            $fieldToValidateParts,
            $validationMethods
        );    
    }
}
