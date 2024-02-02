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

    public static function invalidValidationFields(): array
    {
        return [
            [['name' => false]],
            [['name' => 1]],
            [['fieldDoesNotExist' => 'Nelson']]
        ];
    }

    #[DataProvider('invalidValidationFields')]
    public function testExecuteMethodReturnsNullForInvalidValidationField(array $requestBody): void
    {
        $this->assertNull($this->trimMethod->execute($requestBody));
    }

    public function testExecuteMethodReturnFieldValueWithoutBlanks(): void
    {
        $withoutBlanks = $this->trimMethod->execute(['name' => ' Nelson Dominici ']);

        $this->assertSame(
            ['name' => 'Nelson Dominici'], 
            $withoutBlanks
        );
    }
}
