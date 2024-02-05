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
        $fieldToValidate = 'email';
        $validationParts = ['email'];
        $customExceptionMessage = '';

        $this->emailMethod = new EmailMethod(
            $fieldToValidate, 
            $validationParts, 
            $customExceptionMessage
        );
    }

    public function testExecuteReturnsNullForTheRequestBodyFieldWithAValueThatIsNotAString(): void
    {
        $requestBody = ['email' => ['nelsoncomer777@gmail.com']];

        $this->assertNull($this->emailMethod->execute($requestBody));
    }

    public function testExecuteReturnsnullWhenTheRequestBodyFieldThatWillBeValidatedDoesNotExist(): void
    {
        $this->assertNull(
            $this->emailMethod->execute(['thisFieldDoesNotExist' => 'nelsoncomer777@gmail.com'])
        );
    }

    public function testExecuteThrowsExceptionIfRequestBodyFieldValueIsNotAValidEmail(): void
    {
        $requestBody = ['email' => 'This is an invalid email'];

        $this->expectException(ValidationMethodException::class);
        $this->expectExceptionMessage('The email field is not a valid email.');
        $this->expectExceptionCode(422);

        $this->emailMethod->execute($requestBody);
    }

    #[DataProvider('requestBodyFieldsWithFalsyValues')]
    public function testExecuteReturnsNullIfTheRequestBodyFieldHasAFalsyValue(array $requestBody): void
    {
        $this->assertNull($this->emailMethod->execute($requestBody));
    }
    
    public static function requestBodyFieldsWithFalsyValues(): array
    {
        return [
            [['email' => false]],
            [['email' => []]],
            [['email' => 0]],
            [['email' => '']],
            [['email' => null]],
        ];
    }
}
