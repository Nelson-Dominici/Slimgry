<?php

declare(strict_types=1);

namespace tests\ValidationMethod\Methods;

use PHPUnit\Framework\TestCase;
use NelsonDominici\Slimgry\ValidationMethod\Methods\NullableMethod;

class NullableMethodTest extends TestCase
{    
    private NullableMethod $nullableMethod;
    
    public function setUp(): void
    {
        $validationParts = ['array'];
        $customExceptionMessage = '';

        $this->nullableMethod = new NullableMethod(
            $validationParts, 
            $customExceptionMessage
        );
    }

    public function testExecuteMustReturnsNull(): void
    {
        $requestBodyField = [];
        $fieldToValidateParts = [];
        $validationMethods = [];

        $this->assertNull(
            $this->nullableMethod->execute(
                $requestBodyField,
                $fieldToValidateParts,
                $validationMethods
            )
        );
    }
}
