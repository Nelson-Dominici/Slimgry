<?php

declare(strict_types=1);

namespace tests\ValidationMethod\Methods;

use PHPUnit\Framework\TestCase;
use NelsonDominici\Slimgry\ValidationMethod\Methods\MinMethod;
use NelsonDominici\Slimgry\Exceptions\ValidationMethodException;
use PHPUnit\Framework\Attributes\DataProvider;

class MinMethodTest extends TestCase
{ 
    private MinMethod $minMethod;
    
    public function setUp(): void
    {
        $validationParts = ['min', '3'];
        $customExceptionMessage = '';

        $this->minMethod = new MinMethod(
            $validationParts, 
            $customExceptionMessage
        );
    }

    public function testExecuteThrowsExceptionForRequestBodyFieldBelowMinimumSize(): void
    {
        $requestBodyField = ['name' => 'ND'];
        $fieldToValidateParts = ['name'];

        $this->expectException(ValidationMethodException::class);
        $this->expectExceptionMessage('The name field cannot be less than 3.');
        $this->expectExceptionCode(422);

        $this->minMethod->execute($requestBodyField, $fieldToValidateParts);
    }
    
    public function testExecuteReturnsNullForRequestBodyFieldAboveMinimumSize(): void
    {
        $requestBodyField = ['name' => 'Nelson'];
        $fieldToValidateParts = ['name'];

        $this->assertNull(
            $this->minMethod->execute(
                $requestBodyField,
                $fieldToValidateParts
            )
        );
    }

    public function testExecuteReturnsNullIfRequestBodyFieldWithTheMinimumSize(): void
    {
        $requestBodyField = ['name' => [1,2,3]];
        $fieldToValidateParts = ['name'];

        $this->assertNull(
            $this->minMethod->execute(
                $requestBodyField,
                $fieldToValidateParts
            )
        );
    }

    public function testExecuteReturnsNullIfRequestBodyFieldDoesNotExist(): void
    {
        $requestBodyField = [];
        $fieldToValidateParts = ['name'];

        $this->assertNull(
            $this->minMethod->execute(
                $requestBodyField,
                $fieldToValidateParts
            )
        );
    }

    public function testExecuteReturnsNullIfRequestBodyFieldIsTrue(): void
    {
        $requestBodyField = ['name' => true];
        $fieldToValidateParts = ['name'];

        $this->assertNull(
            $this->minMethod->execute(
                $requestBodyField,
                $fieldToValidateParts
            )
        );
    }

    #[DataProvider('falsyBodyFields')]
    public function testExecuteReturnsNullForFalsyRequestBodyField(array $bodyField): void
    {
        $fieldToValidateParts = ['name'];

        $this->assertNull(
            $this->minMethod->execute(
                $bodyField,
                $fieldToValidateParts
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
 