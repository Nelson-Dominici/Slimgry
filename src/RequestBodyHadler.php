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

        $this->validatedBody = array_merge(
            $this->validatedBody, 
            $newValidatedField
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

                unset($this->requestBody[$fieldToValidateParts[0]]);
                
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
