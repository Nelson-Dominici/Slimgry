<?php

declare(strict_types=1);

namespace tests\ValidationMethod\Methods;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use NelsonDominici\Slimgry\Exceptions\ValidationMethodException;
use NelsonDominici\Slimgry\ValidationMethod\Methods\RequiredMethod;

class RequiredMethodTest extends TestCase
{
    private RequiredMethod $requiredMethod;
    
    public function setUp(): void
    {
        $fieldToValidate = 'name';
        $validationParts = ['required'];
        $customExceptionMessage = '';

        $this->requiredMethod = new RequiredMethod(
            $fieldToValidate, 
            $validationParts, 
            $customExceptionMessage
        );
    }

    #[DataProvider('fieldsConsideredEmpty')]
    public function testThrowsExceptionForFieldToValidateThatAreConsideredEmpty(array $requestBody): void
    {
        $this->expectException(ValidationMethodException::class);
        $this->expectExceptionMessage('The name field is required.');
        $this->expectExceptionCode(422);

        $this->requiredMethod->execute($requestBody);
    }
    
    public static function fieldsConsideredEmpty(): array
    {
        return [
            [['fieldDoesNotExist' => 'Nelson']],
            [['name' => '']],
            [['name' => []]],
            [['name' => null]]
        ];
    }

    public function testReturnsNullWhenTheFieldToValidateIsNotOneOfTheFieldsConsideredEmpty(): void
    {
        $requestBody = ['name' => 'Nelson'];

        $this->assertNull($this->requiredMethod->execute($requestBody));
    }
}
