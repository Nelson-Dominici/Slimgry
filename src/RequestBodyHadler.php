<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry;

class RequestBodyHadler
{
    private array $requestBody; 
    private array $validatedBody;
            
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
    
    public function updateValidatedBody(?array $newValidatedField): void
    {
        if (!$newValidatedField) {
            return;
        }

        $this->validatedBody = array_merge($this->validatedBody, $newValidatedField);
    }

    public function getValidatedBody(): array
    {
        return $this->validatedBody;
    }

    public function getRequestBody(): array
    {
        return $this->requestBody;
    }
}
