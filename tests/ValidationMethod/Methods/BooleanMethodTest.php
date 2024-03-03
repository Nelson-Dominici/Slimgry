<?php

declare(strict_types=1);

namespace tests\ValidationMethod\Methods;

use PHPUnit\Framework\TestCase;
use NelsonDominici\Slimgry\Exceptions\ValidationMethodException;
use NelsonDominici\Slimgry\ValidationMethod\Methods\BooleanMethod;

class BooleanMethodTest extends TestCase
{    
    private BooleanMethod $booleanMethod;
    
    public function setUp(): void
    {
        $validationParts = ['boolean'];
        $customExceptionMessage = '';

        $this->booleanMethod = new BooleanMethod(
            $validationParts, 
            $customExceptionMessage
        );
    }

    public function testExecuteReturnsNullIfRequestBodyFieldCanBeNullable(): void
    {
        $requestBodyField = ['adm' => null];
        $fieldToValidateParts = ['adm'];
        $validationMethods = ['nullable'];

        $this->assertNull(
            $this->booleanMethod->execute(
                $requestBodyField,
                $fieldToValidateParts,
                $validationMethods
            )
        );
    }

    public function testExecuteReturnsNullIfRequestBodyFieldDoesNotExist(): void
    {
        $validationMethods = [];
        $requestBodyField = [];
        $fieldToValidateParts = ['adm'];

        $this->assertNull(
            $this->booleanMethod->execute(
                $requestBodyField,
                $fieldToValidateParts,
                $validationMethods
            )
        );
    }

    public function testExecuteReturnsNullIfRequestBodyFieldIsAValidBoolean(): void
    {
        $requestBodyField = ['adm' => true];
        $validationMethods = [];

        $fieldToValidateParts = ['users','nelson','adm'];

        $this->assertNull(
            $this->booleanMethod->execute(
                $requestBodyField,
                $fieldToValidateParts,
                $validationMethods
            )
        );
    }

    public function testExecuteThrowsExceptionIfRequestBodyFieldIsNotAValidBoolean(): void
    {
        $validationMethods = [];
        $requestBodyField = ['adm' => 'true'];
        $fieldToValidateParts = ['users','nelson','adm'];

        $this->expectException(ValidationMethodException::class);
        $this->expectExceptionMessage('The users.nelson.adm field must be a valid boolean.');
        $this->expectExceptionCode(422);

        $this->booleanMethod->execute(
            $requestBodyField, 
            $fieldToValidateParts,
            $validationMethods
        );
    }
}
