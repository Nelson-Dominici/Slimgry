<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry;

class RequestBodyHandler
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
    
    public function updateValidatedBody(?array $newFieldValue, array $fieldToValidateParts): void
    {
        if (!$newFieldValue) {
            return;
        } 
        
        $validatedField = array_reduce(array_reverse($fieldToValidateParts), function ($carry, $field) use ($newFieldValue) {
            if ($carry === null) {
                return [$field => $newFieldValue[0]];
            }
        
            return [$field => $carry];
        }, null);
        
        $this->validatedBody = array_merge(
            $this->validatedBody, 
            $validatedField
        );
    }

    public function getBodyField(array $fieldToValidateParts): ?array
    {
        $bodyField = $this->requestBody;

        $fieldToValidate = end($fieldToValidateParts);
    
        foreach ($fieldToValidateParts as $field) {

            if (!array_key_exists($field, $bodyField)) {
                return [];
            }
    
            $bodyField = $bodyField[$field];
    
            if ($field === $fieldToValidate) {
                
                return [$field => $bodyField];
            }
    
            if (!is_array($bodyField)) {
                return [];
            }
        }
    
        return [];
    }

    public function getValidatedBody(): array
    {
        return $this->validatedBody;
    }
}
