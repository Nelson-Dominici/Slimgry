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
	
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
	    $this->validate(
            $this->bodyValidations, 
            $request->getParsedBody(), 
            $this->customExceptionMessages
        );
        
	  	return $handler->handle($request);
    }
}
