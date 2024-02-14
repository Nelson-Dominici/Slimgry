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
        $fieldToValidate = 'adm';
        $validationParts = ['boolean'];
        $customExceptionMessage = '';

        $this->booleanMethod = new BooleanMethod(
            $fieldToValidate, 
            $validationParts, 
            $customExceptionMessage
        );
    }

    public function testExecuteReturnsnullWhenTheRequestBodyFieldDoesNotExist(): void
    {
        $this->assertNull(
            $this->booleanMethod->execute(['thisFieldIsNotExpected' => true])
        );
    }

    public function testExecuteThrowsExceptionIfRequestBodyFieldIsNotAValidBoolean(): void
    {
        $requestBody = ['adm' => 'true'];

        $this->expectException(ValidationMethodException::class);
        $this->expectExceptionMessage('The adm field is not a valid boolean.');
        $this->expectExceptionCode(422);

        $this->booleanMethod->execute($requestBody);
    }
}
