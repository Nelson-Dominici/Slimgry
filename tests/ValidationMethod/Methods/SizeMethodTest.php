<?php

declare(strict_types=1);

namespace tests\ValidationMethod\Methods;

use NelsonDominici\Slimgry\Exceptions\ValidationMethodException;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use NelsonDominici\Slimgry\ValidationMethod\Methods\SizeMethod;

class SizeMethodTest extends TestCase
{ 
    private SizeMethod $sizeMethod;
    
    public function setUp(): void
    {
        $fieldToValidate = 'name';
        $validationParts = ['size', '4'];
        $customExceptionMessage = '';

        $this->sizeMethod = new SizeMethod(
            $fieldToValidate, 
            $validationParts, 
            $customExceptionMessage
        );
    }

    public function testExecuteThrowsExceptionWhenRequestBodyFieldDoesNotHaveTheSpecifiedSize(): void
    {
        $requestBody = ['name' => '12345'];

        $this->expectException(ValidationMethodException::class);
        $this->expectExceptionMessage('The name field must be 4 characters.');
        $this->expectExceptionCode(422);

        $this->sizeMethod->execute($requestBody);
    }
    
    #[DataProvider('requestBodyFieldsThatCannotBeValidated')]
    public function testExecuteReturnsNullWhenFieldCannotBeValidatedInRequestBody(array $requestBody): void
    {
        $this->assertNull($this->sizeMethod->execute($requestBody));
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
 