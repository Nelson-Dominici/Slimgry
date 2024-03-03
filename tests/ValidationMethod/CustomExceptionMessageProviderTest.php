<?php

declare(strict_types=1);

namespace tests\ValidationMethod;

use PHPUnit\Framework\TestCase;
use NelsonDominici\Slimgry\ValidationMethod\CustomExceptionMessageProvider;

class CustomExceptionMessageProviderTest extends TestCase
{
    public function testGetMessageReturnsCustomMessageIfItExists(): void
    {
        $customExceptionMessages = [
            'name.required' => 'This field is required.'
        ];

        $customExceptionMessageProvider = new CustomExceptionMessageProvider(
            $customExceptionMessages
        );

        $customMessage = $customExceptionMessageProvider->getMessage(
            ['name'],
            'required'
        );

        $this->assertEquals('This field is required.', $customMessage);
    }

    function testGetMessageReturnsEmptyStringIfCustomMessageDoesNotExist(): void
    {
        $customExceptionMessages = [];

        $customExceptionMessageProvider = new CustomExceptionMessageProvider(
            $customExceptionMessages
        );

        $customMessage = $customExceptionMessageProvider->getMessage(
            ['name'],
            'required'
        );

        $this->assertSame('', $customMessage);
    }
}
