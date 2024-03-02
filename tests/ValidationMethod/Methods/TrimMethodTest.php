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
        $validationParts = ['trim'];
        $customExceptionMessage = '';

        $this->trimMethod = new TrimMethod(
            $validationParts, 
            $customExceptionMessage
        );
    }

    #[DataProvider('falsyBodyFields')]
    public function testExecuteReturnsNullForFalsyRequestBodyField(array $bodyField): void
    {
        $fieldToValidateParts = ['name'];
        $validationMethods = [];

        $this->assertNull(
            $this->trimMethod->execute(
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

    public function testExecuteReturnsNullIfRequestBodyFieldHasNotStringValue(): void
    {
        $requestBodyField = ['name' => 13];
        $fieldToValidateParts = ['name'];
        $validationMethods = [];

        $this->assertNull(
            $this->trimMethod->execute(
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
            $this->trimMethod->execute(
                $requestBodyField,
                $fieldToValidateParts,
                $validationMethods
            )
        );
    }
    
    public function testExecuteMethodReturnFieldValueWithoutBlanks(): void
    {
        $requestBodyField = ['name' => ' Nelson Dominici '];
        $fieldToValidateParts = ['name'];
        $validationMethods = [];

        $expectedData = ['Nelson Dominici'];

        $this->assertSame(
            $this->trimMethod->execute(
                $requestBodyField,
                $fieldToValidateParts,
                $validationMethods
            ),
            $expectedData
        );
    }
}
