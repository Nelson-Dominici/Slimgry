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
        $validationParts = ['gte', '1000'];
        $customExceptionMessage = '';

        $this->gteMethod = new GteMethod(
            $validationParts, 
            $customExceptionMessage
        );
    }

    public function testExecuteReturnsNullIfRequestBodyFieldIsAboveTheMethodValue(): void
    {
        $requestBodyField = ['money' => 5000];
        $fieldToValidateParts = ['money'];
        $validationMethods = [];

        $this->assertNull(
            $this->gteMethod->execute(
                $requestBodyField,
                $fieldToValidateParts,
                $validationMethods
            )
        );
    }

    public function testExecuteReturnsNullIfRequestBodyFieldIsEqualsTheMethodValue(): void
    {
        $requestBodyField = ['money' => 1000];
        $fieldToValidateParts = ['money'];
        $validationMethods = [];

        $this->assertNull(
            $this->gteMethod->execute(
                $requestBodyField,
                $fieldToValidateParts,
                $validationMethods
            )
        );
    }

    public function testExecuteReturnsNullIfRequestBodyFieldDoesNotExist(): void
    {
        $requestBodyField = [];
        $fieldToValidateParts = ['money'];
        $validationMethods = [];

        $this->assertNull(
            $this->gteMethod->execute(
                $requestBodyField,
                $fieldToValidateParts,
                $validationMethods
            )
        );
    }

    public function testExecuteReturnsnullIfTheRequestBodyFieldIsNotNumeric(): void
    {
        $requestBodyField = ['money' => []];
        $fieldToValidateParts = ['money'];
        $validationMethods = [];

        $this->assertNull(
            $this->gteMethod->execute(
                $requestBodyField,
                $fieldToValidateParts,
                $validationMethods
            )
        );
    }
    
    public function testExecuteThrowsExceptionIfRequestBodyFieldIsNotAboveMethodValue(): void
    {
        $requestBodyField = ['money' => '100'];
        $fieldToValidateParts = ['money'];
        $validationMethods = [];

        $this->expectException(ValidationMethodException::class);
        $this->expectExceptionMessage('The money field must be greater than or equal to 1000.');
        $this->expectExceptionCode(422);

        $this->gteMethod->execute(
            $requestBodyField, 
            $fieldToValidateParts,
            $validationMethods
        );
    }
}
