<?php

declare(strict_types=1);

namespace tests\ValidationMethod;

use PHPUnit\Framework\TestCase;
use NelsonDominici\Slimgry\ValidationMethod\ValidationMethodsHandler;
use NelsonDominici\Slimgry\Exceptions\ValidationMethodSyntaxException;

class ValidationMethodsHandlerTest extends TestCase
{
    private ValidationMethodsHandler $validationMethodsHandler;

    public function setUp(): void
    {
        $this->validationMethodsHandler = new ValidationMethodsHandler();
    }

    public function testCheckMethodColonThrowsExceptionForMethodsWithMoreThanOneColon(): void
    {
        $validationMethod = 'min::3';
    
        $this->expectException(ValidationMethodSyntaxException::class);
        $this->expectExceptionMessage(
            "Invalid validation method sintax. The \"min::3\" validation method cannot have more than one \":\"."
        );

        $this->validationMethodsHandler->checkMethodColon($validationMethod);
    }

    public function testCheckMethodColonReturnsNullForCommonTypeValidationMethod(): void
    {
        $validationMethod = 'string';

        $this->assertNull(
            $this->validationMethodsHandler->checkMethodColon($validationMethod)
        );
    }

    public function testCheckMethodColonReturnsNullForValidationMethodOfTypeKeyValue(): void
    {
        $validationMethod = 'min:2';

        $this->assertNull(
            $this->validationMethodsHandler->checkMethodColon($validationMethod)
        );
    }

    public function testRemoveDuplicateMethodsRemovesDuplicateMethods(): void
    {
        $duplicateNethods = 'required|min:4|trim|trim|string|string|min:3';

        $noDuplications = $this->validationMethodsHandler->removeDuplicateMethods(
            $duplicateNethods
        );

        $this->assertSame(
            ['required','min:3','trim','string'],
            $noDuplications
        );
    }
}