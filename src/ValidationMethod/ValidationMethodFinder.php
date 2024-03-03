<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\ValidationMethod;

use NelsonDominici\Slimgry\Exceptions\ValidationMethodSyntaxException;

class ValidationMethodFinder
{
    private function buildMethodPath(string $methodName, bool $useAcronym): string
    {
        $namespace = __NAMESPACE__;

        $methodsFolder = 'Methods';
        
        if ($useAcronym) {

            return "$namespace\\$methodsFolder\\".ucfirst($methodName).'Method';
        }

        return "$namespace\\$methodsFolder\\".strtoupper($methodName).'Method';
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