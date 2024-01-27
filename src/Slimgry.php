<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry;

use Psr\Http\Message\{ 
	ResponseInterface as Response,
	ServerRequestInterface as Request
};

use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

use NelsonDominici\Slimgry\ValidationMethod\{
    ValidationMethodFinder,
    ValidationMethodsHandler,
    ValidationMethodExecutor,
    ValidationMethodInstantiator,
    CustomExceptionMessageProvider
};

final class Slimgry
{
	public function __construct(
		private array $bodyValidations,
		private array $customExceptionMessages = []
	) {}

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $instantiator = new ValidationMethodInstantiator(
            new ValidationMethodFinder(),
            new CustomExceptionMessageProvider($this->customExceptionMessages)
        );

        $requestBodyHandler = new RequestBodyHadler($request->getParsedBody());
        
        $validationMethodsHandler = new ValidationMethodsHandler();     

        $validationMethodExecutor = new ValidationMethodExecutor(
            $this->bodyValidations,
            $validationMethodsHandler,
            $requestBodyHandler,
            $instantiator
        );
        
        $validatedBody = $validationMethodExecutor->performFieldValidationMethods();

        $request = $request->withAttribute("validated", $validatedBody);

	  	return $handler->handle($request);
    }
}
