<?php

namespace NelsonDominici\Slimgry;

use Psr\Http\Message\{ 
	ResponseInterface as Response,
	ServerRequestInterface as Request
};

use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class Slimgry extends Validator
{
	public function __construct(
		private array $bodyValidations
	){}

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
	    $this->validate($this->bodyValidations, $request->getParsedBody());

	  	return $handler->handle($request);
    }
}
