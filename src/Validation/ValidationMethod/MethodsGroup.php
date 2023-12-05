<?php

declare(strict_types=1);

namespace NelsonDominici\Slimgry\Validation\Methods;

trait MethodsGroup
{
    private const METHODS = [
        'min' => Methods\MinMethod::class,
        'trim' => Methods\TrimMethod::class,
        'max' => Methods\MaxMethod::class,
        'string' => Methods\StringMethod::class,
        'required' => Methods\RequiredMethod::class
    ];
}
