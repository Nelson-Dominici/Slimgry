<?php

declare(strict_types=1);

namespace tests\ValidationMethod\Methods;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use NelsonDominici\Slimgry\ValidationMethod\Methods\TrimMethod;

class TrimMethodTest extends TestCase
{
    private TrimMethod $trimMethod;
    
    public function setUp(): void
    {
        $fieldToValidate = 'name';
        $validationParts = ['trim'];
        $customExceptionMessage = '';

        $this->trimMethod = new TrimMethod(
            $fieldToValidate, 
            $validationParts, 
            $customExceptionMessage
        );
    }

    public static function requestBodyFieldsWithFalseValues(): array
    {
        return [
            [['name' => false]],
            [['name' => []]],
            [['name' => 0]],
            [['name' => ""]],
            [['name' => null]],
        ];
    }
    
    #[DataProvider('requestBodyFieldsWithFalseValues')]
    public function testReturnsNullWhenTheRequestBodyFieldHasAFalsyValue(array $requestBody): void
    {
        $this->assertNull($this->trimMethod->execute($requestBody));
    }

    public function testReturnsNullWhenTheRequestBodyFieldHasNotStringValue(): void
    {
        $this->assertNull($this->trimMethod->execute(['name' => 10]));
    }

    public function testReturnsNullWhenTheRequestBodyFieldDoesNotExist(): void
    {
        $this->assertNull(
            $this->trimMethod->execute(['thisFieldDoesNotExist' => 'Nelson'])
        );
    }
    
    public function testExecuteMethodReturnFieldValueWithoutBlanks(): void
    {
        $requestBody = ['name' => ' Nelson Dominici '];

        $trimmedData = $this->trimMethod->execute($requestBody);
    
        $expectedData = ['name' => 'Nelson Dominici'];
        
        $this->assertSame($expectedData, $trimmedData);
    }
}
