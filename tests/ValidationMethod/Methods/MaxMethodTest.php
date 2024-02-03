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
        $fieldToValidate = 'name';
        $validationParts = ['max', '10'];
        $customExceptionMessage = '';

        $this->maxMethod = new MaxMethod(
            $fieldToValidate, 
            $validationParts, 
            $customExceptionMessage
        );
    }

    public function testExecuteThrowsExceptionForRequestBodyFieldWithValueAboveMaximumSize(): void
    {
        $requestBody = ['name' => 12345678910];

        $this->expectException(ValidationMethodException::class);
        $this->expectExceptionMessage('The name field cannot be greater than 10.');
        $this->expectExceptionCode(422);

        $this->maxMethod->execute($requestBody);
    }

    public function testExecuteReturnsNullForTheRequestBodyFieldWithAValueEqualToTheMaximumSize(): void
    {
        $requestBody = ['name' => ['0','1','2','3','4','5','6','7','8','9']];

        $this->assertNull($this->maxMethod->execute($requestBody));
    }
    
    public function testExecuteReturnsNullForTheRequestBodyFieldWithAValueBelowTheMaximumSize(): void
    {
        $requestBody = ['name' => '123456789'];

        $this->assertNull($this->maxMethod->execute($requestBody));
    }

    #[DataProvider('requestBodyFieldsThatCannotBeValidated')]
    public function testExecuteReturnsNullWhenFieldCannotBeValidatedInRequestBody(array $requestBody): void
    {
        $this->assertNull($this->maxMethod->execute($requestBody));
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
            [['nameFieldDoesNotExist' => 'Nelson']],
        ];
    }
}
