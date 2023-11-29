<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry;

use Psr\Http\Message\{ 
	ResponseInterface as Response,
	ServerRequestInterface as Request
};
use NelsonDominici\Slimgry\Validation\Validation;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

final class Slimgry extends Validation
{
	public function __construct(
		private array $bodyValidations,
		private array $customExceptionMessages = []
	){}
        
    private function parseRequestBody(null|array|\SimpleXMLElement $requestBody): array
    {
        if ($requestBody instanceof \SimpleXMLElement) {
            return get_object_vars($requestBody);
        }

        return (array) $requestBody ?? [];
    }
	
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $requestBody = $this->parseRequestBody($request->getParsedBody());

	    $validatedRequestBody = $this->validate(
            $requestBody,
            $this->bodyValidations, 
            $this->customExceptionMessages
        );
        
	  	return $handler->handle($request);
    }
}
