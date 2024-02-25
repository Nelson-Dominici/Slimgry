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

        $this->assertNull(
            $this->trimMethod->execute(
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

    public function testExecuteReturnsNullIfRequestBodyFieldHasNotStringValue(): void
    {
        $requestBodyField = ['name' => 13];
        $fieldToValidateParts = ['name'];

        $this->assertNull(
            $this->trimMethod->execute(
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
            $this->trimMethod->execute(
                $requestBodyField,
                $fieldToValidateParts
            )
        );
    }
    
    public function testExecuteMethodReturnFieldValueWithoutBlanks(): void
    {
        $requestBodyField = ['name' => ' Nelson Dominici '];
        $fieldToValidateParts = ['name'];

        $expectedData = ['Nelson Dominici'];

        $this->assertSame(
            $this->trimMethod->execute(
                $requestBodyField,
                $fieldToValidateParts
            ),
            $expectedData
        );
    }
}
