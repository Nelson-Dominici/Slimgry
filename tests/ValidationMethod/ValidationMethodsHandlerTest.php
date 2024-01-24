<?php

declare(strict_types=1);

namespace tests\ValidationMethod;

use PHPUnit\Framework\TestCase;
use NelsonDominici\Slimgry\ValidationMethod\ValidationMethodsHandler;
use NelsonDominici\Slimgry\Exceptions\ValidationMethodSyntaxException;

class ValidationMethodsHandlerTest extends TestCase
{
    public function testAnExceptionMustBeThrownIfOneOfTheValidationMethodsHasMoreThanOneColon()
    {
        $validationMethodsHandler = new ValidationMethodsHandler();

        $validationMethods = 'required|trim|string|min::3';

        $this->expectException(ValidationMethodSyntaxException::class);
        $this->expectExceptionMessage("The \"min::3\" validation method cannot have more than \":\".");

        $validationMethodsHandler->handle($validationMethods);
    }
}