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

    public function testHandleMethodThrowsExceptionWhenAKeyValueValidationMethodHasMoreThanOneColon(): void
    {
        $validationMethods = 'required|trim|string|min::3';

        $this->expectException(ValidationMethodSyntaxException::class);
        $this->expectExceptionMessage("The \"min::3\" validation method cannot have more than \":\".");

        $this->validationMethodsHandler->handle($validationMethods);
    }

    public function testHandleMethodRemovesRepeatedValidationMethods(): void
    {
        $validationMethodsWithRepetitions = 'required|min:4|trim|trim|string|string|min:3';

        $validationMethodsWithoutRepetitions = $this->validationMethodsHandler->handle(
            $validationMethodsWithRepetitions
        );

        $this->assertSame(
            ['required','min:3','trim','string'],
            $validationMethodsWithoutRepetitions
        );
    }
}