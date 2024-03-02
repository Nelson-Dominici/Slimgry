<?php

declare(strict_types=1);

namespace tests\ValidationMethod\Methods;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use NelsonDominici\Slimgry\ValidationMethod\Methods\MaxMethod;
use NelsonDominici\Slimgry\Exceptions\ValidationMethodException;

class MaxMethodTest extends TestCase
{    
    private MaxMethod $maxMethod;
    
    public function setUp(): void
    {
        $validationParts = ['max', '10'];
        $customExceptionMessage = '';

        $this->maxMethod = new MaxMethod(
            $validationParts, 
            $customExceptionMessage
        );
    }

    public function testExecuteThrowsExceptionIfRequestBodyFieldIsAboveMaximumSize(): void
    {
        $requestBodyField = ['name' => '123456791011'];
        $fieldToValidateParts = ['name'];
        $validationMethods = [];

        $this->expectException(ValidationMethodException::class);
        $this->expectExceptionMessage('The name field cannot be greater than 10.');
        $this->expectExceptionCode(422);

        $this->maxMethod->execute(
            $requestBodyField, 
            $fieldToValidateParts,
            $validationMethods
        );
    }

    public function testExecuteReturnsNullIfRequestBodyFieldIsEqualsTheMethodValue(): void
    {
        $requestBodyField = ['name' => ['1','2','3','4','5','6','7','8','9','1']];
        $fieldToValidateParts = ['name'];
        $validationMethods = [];

        $this->assertNull(
            $this->maxMethod->execute(
                $requestBodyField,
                $fieldToValidateParts,
                $validationMethods
            )
        );
    }
    
    public function testExecuteReturnsNullIfRequestBodyFieldIsBelowTheMaximumSize(): void
    {
        $requestBodyField = ['name' => 123456789];
        $fieldToValidateParts = ['name'];
        $validationMethods = [];

        $this->assertNull(
            $this->maxMethod->execute(
                $requestBodyField,
                $fieldToValidateParts,
                $validationMethods
            )
        );
    }

    public function testExecuteReturnsNullIfRequestBodyFieldDoesNotExist(): void
    {
        $requestBodyField = [];
        $fieldToValidateParts = ['name'];
        $validationMethods = [];

        $this->assertNull(
            $this->maxMethod->execute(
                $requestBodyField,
                $fieldToValidateParts,
                $validationMethods
            )
        );
    }

    public function testExecuteReturnsNullIfRequestBodyFieldIsTrue(): void
    {
        $requestBodyField = ['name' => true];
        $fieldToValidateParts = ['name'];
        $validationMethods = [];

        $this->assertNull(
            $this->maxMethod->execute(
                $requestBodyField,
                $fieldToValidateParts,
                $validationMethods
            )
        );
    }

    #[DataProvider('falsyBodyFields')]
    public function testExecuteReturnsNullForFalsyRequestBodyField(array $bodyField): void
    {
        $fieldToValidateParts = ['name'];
        $validationMethods = [];

        $this->assertNull(
            $this->maxMethod->execute(
                $bodyField,
                $fieldToValidateParts,
                $validationMethods
            )
        );
    }
    
    public static function falsyBodyFields(): array
    {
        return [
            [['name' => false]],
            [['name' => []]],
            [['name' => 0]],
            [['name' => ""]],
            [['name' => null]],
        ];
    }
}
