<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod;

use NelsonDominici\Slimgry\Exceptions\ValidationMethodSyntaxException;

class ValidationMethodFinder
{
    private function buildMethodPath(string $validationMethodName, bool $useAcronym): string
    {
        $namespace = __NAMESPACE__;
        $methodDirectory = 'Methods';
        $methodName = $useAcronym ? ucfirst($validationMethodName) : strtoupper($validationMethodName);

        return "$namespace\\$methodDirectory\\{$methodName}Method";
    }

    public function find(string $validationMethodName): string
    {
        $methodPath = $this->buildMethodPath($validationMethodName, false);

        if (class_exists($methodPath) && $validationMethodName !== 'validation') {
            return $methodPath;
        }

        $methodPath = $this->buildMethodPath($validationMethodName, true);

        if (class_exists($methodPath) && $validationMethodName !== 'validation') {
            return $methodPath;
        }

        $message = "Validation method \"$validationMethodName\" does not exist.";

        throw new ValidationMethodSyntaxException(
            $message, $validationMethodName, 404
        );        
    }
}