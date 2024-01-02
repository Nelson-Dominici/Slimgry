<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry;

class RequestBodyHadler
{
    public array $requestBody; 
    public array $validatedBody;
            
    public function __construct(null|array|\SimpleXMLElement $requestBody)
    {
        $parsedBody =  $this->parse($requestBody);

        $this->requestBody = $parsedBody;
        $this->validatedBody = $parsedBody;
    }

    private function parse(null|array|\SimpleXMLElement $requestBody): array
    {
        if ($requestBody instanceof \SimpleXMLElement) {
            return get_object_vars($requestBody);
        }

        return (array) $requestBody ?? [];
    }
    
    public function newValidatedFieldValue(?array $newValidatedRequestBody): void
    {
        $this->validatedBody = $newValidatedRequestBody ?: $this->validatedBody;
    }
}
