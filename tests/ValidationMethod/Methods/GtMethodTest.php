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
        $validationParts = ['gt', '1000'];
        $customExceptionMessage = '';

        $this->gtMethod = new GtMethod(
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
            $this->gtMethod->execute(
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
            $this->gtMethod->execute(
                $requestBodyField,
                $fieldToValidateParts,
                $validationMethods
            )
        );
    }

    public function testExecuteReturnsNullIfRequestBodyFieldIsNotNumeric(): void
    {
        $requestBodyField = ['money' => null];
        $fieldToValidateParts = ['money'];
        $validationMethods = [];

        $this->assertNull(
            $this->gtMethod->execute(
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
        $this->expectExceptionMessage('The money field must be greater than 1000.');
        $this->expectExceptionCode(422);

        $this->gtMethod->execute(
            $requestBodyField, 
            $fieldToValidateParts,
            $validationMethods
        );
    }
}
