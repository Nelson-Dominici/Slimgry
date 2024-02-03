<?php

declare(strict_types=1);

namespace tests\ValidationMethod\Methods;

use NelsonDominici\Slimgry\Exceptions\ValidationMethodException;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use NelsonDominici\Slimgry\ValidationMethod\Methods\MinMethod;

class MinMethodTest extends TestCase
{ 
    private MinMethod $minMethod;
    
    public function setUp(): void
    {
        $fieldToValidate = 'name';
        $validationParts = ['min', '3'];
        $customExceptionMessage = '';

        $this->minMethod = new MinMethod(
            $fieldToValidate, 
            $validationParts, 
            $customExceptionMessage
        );
    }

    public function testExecuteThrowsExceptionForRequestBodyFieldBelowMinimumSize(): void
    {
        $requestBody = ['name' => 12];

        $this->expectException(ValidationMethodException::class);
        $this->expectExceptionMessage('The name field cannot be less than 3.');
        $this->expectExceptionCode(422);

        $this->minMethod->execute($requestBody);
    }
    
    public function testExecuteReturnsNullForRequestBodyFieldAboveMinimumSize(): void
    {
        $requestBody = ['name' => 'Nelson'];

        $this->assertNull($this->minMethod->execute($requestBody));
    }

    public function testExecuteReturnsNullForTheRequestBodyFieldWithTheMinimumSize(): void
    {
        $requestBody = ['name' => 123];

        $this->assertNull($this->minMethod->execute($requestBody));
    }
    
    #[DataProvider('requestBodyFieldsThatCannotBeValidated')]
    public function testExecuteReturnsNullWhenFieldCannotBeValidatedInRequestBody(array $requestBody): void
    {
        $this->assertNull($this->minMethod->execute($requestBody));
    }
    
    public static function requestBodyFieldsThatCannotBeValidated(): array
    {
        return [
            [['name' => false]],
            [['name' => []]],
            [['name' => 0]],
            [['name' => ""]],
            [['name' => null]],
            [['name' => true]],
            [['thisFieldDoesNotExist' => 'Nelson']],
        ];
    }
}
 