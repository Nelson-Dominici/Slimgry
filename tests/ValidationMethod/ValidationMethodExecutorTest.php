<?php

declare(strict_types=1);

namespace tests\ValidationMethod;

use PHPUnit\Framework\TestCase;

use NelsonDominici\Slimgry\RequestBodyHadler;

use NelsonDominici\Slimgry\ValidationMethod\{
    ValidationMethodExecutor,
    ValidationMethodsHandler,
    ValidationMethodInstantiator
};

use NelsonDominici\Slimgry\ValidationMethod\Methods\RequiredMethod;

class ValidationMethodExecutorTest extends TestCase
{
    private RequestBodyHadler $requestBodyHadler;
    private ValidationMethodsHandler $validationMethodsHandler;
    private ValidationMethodExecutor $validationMethodExecutor;
    private ValidationMethodInstantiator $validationMethodInstantiator;

    public function setUp(): void
    {
        $bodyValidations = [
            'name' => 'required|string',
        ];

        $this->requestBodyHadler = $this->createMock(RequestBodyHadler::class);
        $this->validationMethodsHandler = $this->createMock(ValidationMethodsHandler::class);
        $this->validationMethodInstantiator = $this->createMock(ValidationMethodInstantiator::class);

        $this->validationMethodsHandler
            ->method('removeDuplicateMethods')
            ->willReturn(['required', 'string']);

        $this->requestBodyHadler
            ->method('getValidatedBody')
            ->willReturn(['name' => 'Nelson']);

        $this->requestBodyHadler
            ->method('getRequestBody')
            ->willReturn(['name' => 'Nelson']);

        $this->validationMethodInstantiator
            ->method('getInstance')
            ->willReturn(
                $this->createMock(RequiredMethod::class)
            );

        $this->validationMethodExecutor = new ValidationMethodExecutor(
            $bodyValidations,
            $this->validationMethodsHandler,
            $this->requestBodyHadler,
            $this->validationMethodInstantiator
        );
    }

    public function testRemoveDuplicateMethodsCalledInTheCorrectAmount(): void
    {
        $this->validationMethodsHandler
            ->expects($this->exactly(1))
            ->method('removeDuplicateMethods');
        
        $this->validationMethodExecutor->performFields();
    }

    public function testCheckMethodColonCalledInTheCorrectAmount(): void
    {
        $this->validationMethodsHandler
            ->expects($this->exactly(2))
            ->method('checkMethodColon');
        
        $this->validationMethodExecutor->performFields();
    }

    public function testRequestBodyHadlerGetValidatedBodyMethodCalledInTheCorrectAmount(): void
    {
        $this->requestBodyHadler
            ->expects($this->exactly(1))
            ->method('getValidatedBody');
    
        $this->validationMethodExecutor->performFields();
    }

    public function testRequestBodyHadlerGetRequestBodyMethodCalledInTheCorrectAmount(): void
    {
        $this->requestBodyHadler
            ->expects($this->exactly(2))
            ->method('getRequestBody');
    
        $this->validationMethodExecutor->performFields();
    }

    function testValidationMethodInstantiatorGetInstanceMethodCalledInTheCorrectAmount(): void
    {
        $this->validationMethodInstantiator
            ->expects($this->exactly(2))
            ->method('getInstance');

        $this->validationMethodExecutor->performFields();
    }
}
