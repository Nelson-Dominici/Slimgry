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

    public static function fieldsToValidateWithFalsyValue(): array
    {
        return [
            [['name' => false]],
            [['name' => []]],
            [['name' => 0]],
            [['name' => ""]],
            [['name' => null]],
        ];
    }
    
    #[DataProvider('fieldsToValidateWithFalsyValue')]
    public function testReturnsNullWhenTheFieldToValidateHasAFalsyValue(array $requestBody): void
    {
        $this->assertNull($this->trimMethod->execute($requestBody));
    }

    public function testReturnsNullWhenTheFieldToValidateHasNotStringValue(): void
    {
        $this->assertNull($this->trimMethod->execute(['name' => 10]));
    }

    public function testReturnsNullWhenTheFieldToValidateDoesNotExist(): void
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
