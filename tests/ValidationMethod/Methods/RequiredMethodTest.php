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
        $validationParts = ['required'];
        $customExceptionMessage = '';

        $this->requiredMethod = new RequiredMethod(
            $validationParts, 
            $customExceptionMessage
        );
    }

    #[DataProvider('fieldsConsideredEmpty')]
    public function testThrowsExceptionIfRequestBodyFieldIsEmpty(array $requestBodyField): void
    {
        $fieldToValidateParts = ['name'];
        $validationMethods = [];

        $this->expectException(ValidationMethodException::class);
        $this->expectExceptionMessage('The name field is required.');
        $this->expectExceptionCode(422);

        $this->requiredMethod->execute(
            $requestBodyField, 
            $fieldToValidateParts,
            $validationMethods
        );
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

    public function testReturnsNullIfRequestBodyFieldIsNotEmpty(): void
    {
        $requestBodyField = ['name' => ['Nelson']];
        $fieldToValidateParts = ['name'];
        $validationMethods = [];

        $this->assertNull(
            $this->requiredMethod->execute(
                $requestBodyField,
                $fieldToValidateParts,
                $validationMethods
            )
        );
    }
}
