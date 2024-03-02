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
        $validationParts = ['size', '4'];
        $customExceptionMessage = '';

        $this->sizeMethod = new SizeMethod(
            $validationParts, 
            $customExceptionMessage
        );
    }

    public function testExecuteThrowsExceptionForMismatchedRequestBodyField(): void
    {
        $requestBodyField = ['name' => ['Nelson', 'Dominici']];
        $fieldToValidateParts = ['name'];
        $validationMethods = [];

        $this->expectException(ValidationMethodException::class);
        $this->expectExceptionMessage('The name field must be 4 characters.');
        $this->expectExceptionCode(422);

        $this->sizeMethod->execute(
            $requestBodyField, 
            $fieldToValidateParts,
            $validationMethods
        );
    }
    
    #[DataProvider('fieldsWithTheRightSize')]
    public function testExecuteReturnsNullForMatchingRequestBodyField(array $bodyField): void
    {
        $fieldToValidateParts = ['name'];
        $validationMethods = [];

        $this->assertNull(
            $this->sizeMethod->execute(
                $bodyField,
                $fieldToValidateParts,
                $validationMethods
            )
        );
    }
    
    public static function fieldsWithTheRightSize(): array
    {
        return [
            [['name' => ['Nelson','Dominici','Gonçalves','Neto']]],
            [['name' => 1234]],
            [['name' => '1234']],
        ];
    }

    public function testExecuteReturnsNullIfRequestBodyFieldIsTrue(): void
    {
        $requestBodyField = ['name' => true];
        $fieldToValidateParts = ['name'];
        $validationMethods = [];

        $this->assertNull(
            $this->sizeMethod->execute(
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
            $this->sizeMethod->execute(
                $requestBodyField,
                $fieldToValidateParts,
                $validationMethods
            )
        );
    }
    
    #[DataProvider('falsyBodyFields')]
    public function testExecuteReturnsNullForFalsyRequestBodyField(array $bodyField): void
    {
        $fieldToValidateParts = ['name'];
        $validationMethods = [];

        $this->assertNull(
            $this->sizeMethod->execute(
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
}
 