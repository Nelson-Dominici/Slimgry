<?php

declare(strict_types=1);

namespace tests\ValidationMethod;

use PHPUnit\Framework\TestCase;
use NelsonDominici\Slimgry\ValidationMethod\ValidationMethodFinder;
use NelsonDominici\Slimgry\Exceptions\ValidationMethodSyntaxException;

class ValidationMethodFinderTest extends TestCase
{
    private ValidationMethodFinder $validationMethodFinder;

    protected function setUp(): void
    {
        $this->validationMethodFinder = new ValidationMethodFinder();
    }

    public function testExceptionThrownWhenValidationMethodFileNotFound(): void
    {
        $validationMethod = 'This validation method does not exist.';

        $this->expectException(ValidationMethodSyntaxException::class);
        
        $this->expectExceptionCode(404);
        
        $this->expectExceptionMessage(
            "Validation method \"$validationMethod\" does not exist."
        );

        $this->validationMethodFinder->find($validationMethod);
    }

    public function testExceptionThrownWhenValidationMethodIsTheValidationAbstractClass(): void
    {
        $validationMethod = 'validation';

        $this->expectException(ValidationMethodSyntaxException::class);
        
        $this->expectExceptionCode(404);

        $this->expectExceptionMessage(
            "Validation method \"validation\" does not exist."
        );

        $this->validationMethodFinder->find($validationMethod);
    }
}
