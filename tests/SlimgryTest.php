<?php

declare(strict_types=1);

namespace tests;

use PHPUnit\Framework\TestCase;

use NelsonDominici\Slimgry\Slimgry;

use Psr\Http\Message\{
    ResponseInterface,
    ServerRequestInterface
};

use Psr\Http\Server\RequestHandlerInterface;

class SlimgryTest extends TestCase
{
    private ServerRequestInterface $requestMock;
    private RequestHandlerInterface $handlerMock;
    private Slimgry $slimgry;
    private array $requestBody;

    public function setUp(): void
    {
        $this->requestBody = ['name' => 'Nelson Dominici'];

        $this->requestMock = $this->createMock(ServerRequestInterface::class);
        $this->handlerMock = $this->createMock(RequestHandlerInterface::class);
        
        $responseMock = $this->createMock(ResponseInterface::class);

        $this->handlerMock
            ->method('handle')
            ->willReturn($responseMock);

        $this->requestMock
            ->method('getParsedBody')
            ->willReturn($this->requestBody);

        $this->requestMock
            ->method('withAttribute')
            ->willReturn($this->returnSelf());

        $customExceptionMessages = [''];
        $bodyValidations = ['name' => 'required|string'];

        $this->slimgry = new Slimgry($bodyValidations, $customExceptionMessages);
    }

    public function testGetParsedBodyMethodOfTheRequestClassIsCalledInTheRightAmount(): void
    {
        $this->requestMock
            ->expects($this->once())
            ->method('getParsedBody');
     
        $this->slimgry->__invoke($this->requestMock, $this->handlerMock);
    }

    public function testInvokeMethodReturnsObjectThatImplementsTheResponseInterface(): void
    {
        $responseInstance = $this->slimgry->__invoke(
            $this->requestMock, 
            $this->handlerMock
        );

        $this->assertInstanceOf(ResponseInterface::class ,$responseInstance);
    }

    public function testWithAttributeMethodOfTheRequestClassReceivesTheValidatedField(): void
    {
        $this->requestMock
            ->expects($this->once())
            ->method('withAttribute')
            ->willReturnCallback(function (string $name, array $value) {

                $this->assertSame('validated', $name);
                $this->assertSame($this->requestBody, $value);
                return true;
            });
        
        $this->slimgry->__invoke($this->requestMock, $this->handlerMock);
    }

    public function testHandleMethodOfTheRequestHandlerClassReceivesTheInstanceOfTheRequestClass(): void
    {
        $this->handlerMock
            ->expects($this->once())
            ->method('handle')
            ->willReturnCallback(function (ServerRequestInterface $request) {

                $this->assertInstanceOf(ServerRequestInterface::class, $request);
                
                return true;
            });
        
        $this->slimgry->__invoke($this->requestMock, $this->handlerMock);
    }
}
