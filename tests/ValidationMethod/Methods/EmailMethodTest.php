<?php

declare(strict_types=1);

namespace tests\ValidationMethod\Methods;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use NelsonDominici\Slimgry\ValidationMethod\Methods\EmailMethod;
use NelsonDominici\Slimgry\Exceptions\ValidationMethodException;

class EmailMethodTest extends TestCase
{    
    private EmailMethod $emailMethod;
    
    public function setUp(): void
    {
        $validationParts = ['email'];
        $customExceptionMessage = '';

        $this->emailMethod = new EmailMethod(
            $validationParts, 
            $customExceptionMessage
        );
    }

    public function testExecuteReturnsNullIfRequestBodyFieldDoesNotExist(): void
    {
        $requestBodyField = [];
        $validationMethods = [];
        $fieldToValidateParts = ['adm'];

        $this->assertNull(
            $this->emailMethod->execute(
                $requestBodyField,
                $fieldToValidateParts,
                $validationMethods
            )
        );
    }
    
    public function testExecuteReturnsNullIfRequestBodyFieldIsAValidEmail(): void
    {
        $requestBodyField = ['email' => 'nelsoncomer777@gmail.com'];
        $fieldToValidateParts = ['email'];
        $validationMethods = [];
        
        $this->assertNull(
            $this->emailMethod->execute(
                $requestBodyField,
                $fieldToValidateParts,
                $validationMethods
            )
        );
    }

    public function testExecuteThrowsExceptionIfRequestBodyFieldIsNotAValidEmail(): void
    {
        $validationMethods = [];
        $requestBodyField = ['email' => 'lol'];
        $fieldToValidateParts = ['email'];

        $this->expectException(ValidationMethodException::class);
        $this->expectExceptionMessage('The email field must be a valid email.');
        $this->expectExceptionCode(422);

        $this->emailMethod->execute(
            $requestBodyField, 
            $fieldToValidateParts,
            $validationMethods
        );
    }
}
