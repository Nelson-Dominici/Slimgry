<?php

declare(strict_types=1);

namespace tests\ValidationMethod;

use PHPUnit\Framework\TestCase;
use NelsonDominici\Slimgry\ValidationMethod\CustomExceptionMessageProvider;

class CustomExceptionMessageProviderTest extends TestCase
{
    public function testReturnsCustomMessageWhenItExists(): void
    {
        $customExceptionMessages = [
            'name.required' => 'This field is required.'
        ];

        $customExceptionMessageProvider = new CustomExceptionMessageProvider(
            $customExceptionMessages
        );

        $customMessage = $customExceptionMessageProvider->getCustomMessage(
            'name',
            'required'
        );

        $this->assertEquals('This field is required.', $customMessage);
    }

    function testReturnsEmptyStringWhenCustomMessageDoesNotExist(): void
    {
        $customExceptionMessages = [];

        $customExceptionMessageProvider = new CustomExceptionMessageProvider(
            $customExceptionMessages
        );

        $customMessage = $customExceptionMessageProvider->getCustomMessage(
            'name',
            'required'
        );

        $this->assertSame('', $customMessage);
    }
}
