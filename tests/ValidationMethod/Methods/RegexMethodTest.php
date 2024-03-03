<?php

declare(strict_types=1);

namespace tests\ValidationMethod\Methods;

use PHPUnit\Framework\TestCase;
use NelsonDominici\Slimgry\Exceptions\ValidationMethodException;
use NelsonDominici\Slimgry\ValidationMethod\Methods\RegexMethod;

class RegexMethodTest extends TestCase
{    
    private RegexMethod $regexMethod;
    
    public function setUp(): void
    {
        $validationParts = ['regex', '/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i'];
        $customExceptionMessage = '';

        $this->regexMethod = new RegexMethod(
            $validationParts, 
            $customExceptionMessage
        );
    }

    public function testExecuteReturnsNullIfRequestBodyFieldCanBeNullable(): void
    {
        $requestBodyField = ['uuid' => null];
        $fieldToValidateParts = ['uuid'];
        $validationMethods = ['nullable'];

        $this->assertNull(
            $this->regexMethod->execute(
                $requestBodyField,
                $fieldToValidateParts,
                $validationMethods
            )
        );
    }

    public function testExecuteReturnsNullWhenTheRequestBodyFieldDoesNotExist(): void
    {
        $validationMethods = [];
        $requestBodyField = [];
        $fieldToValidateParts = ['uuid'];

        $this->assertNull(
            $this->regexMethod->execute(
                $requestBodyField,
                $fieldToValidateParts,
                $validationMethods
            )
        );
    }

    public function testThrowsExceptionOnInvalidRequestBodyFieldFormat(): void
    {
        $requestBodyField = ['uuid' => null];
        $fieldToValidateParts = ['uuid'];
        $validationMethods = [];

        $this->expectException(ValidationMethodException::class);
        $this->expectExceptionMessage('The uuid field format is invalid.');
        $this->expectExceptionCode(422);

        $this->regexMethod->execute(
            $requestBodyField, 
            $fieldToValidateParts,
            $validationMethods
        );
    }
}
