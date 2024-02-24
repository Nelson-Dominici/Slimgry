<?php

declare(strict_types=1);

namespace tests;

use PHPUnit\Framework\TestCase;
use NelsonDominici\Slimgry\RequestBodyHandler;
use PHPUnit\Framework\Attributes\DataProvider;

class RequestBodyHandlerTest extends TestCase
{
    public static function requestBodyTypes(): array
    {
        return [
            [[
                'name' => 'Davidson', 
                'email' => 'Davidson123@gmail.com',
                'password' => '123456'
            ]],
            [new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?>
                <user>
                    <name>Davidson</name>
                    <email>Davidson123@gmail.com</email>
                    <password>123456</password>
                </user>'
            )],
            [null]
        ];
    }

    #[DataProvider('requestBodyTypes')]
    public function testParseMethodReturnsArrayRegardlessOfRequestBodyType($requestBody): void 
    {
        $requestBodyHandler = new RequestBodyHandler($requestBody);

        $this->assertIsArray($requestBodyHandler->getValidatedBody());
    }
    
    public function testUpdateValidatedBodyUpdatesWhenParameterIsNotNull(): void
    {
        $fieldToValidateParts = ['email'];
        
        $requestBody = ['name' => 'Davidson'];
        
        $newFieldValue = ['nelsoncomer777@gmail.com'];

        $requestBodyHandler = new RequestBodyHandler($requestBody);
        
        $requestBodyHandler->updateValidatedBody(
            $newFieldValue, 
            $fieldToValidateParts
        );

        $this->assertSame(
            [
                'name' => 'Davidson',
                'email' => 'nelsoncomer777@gmail.com'
            ],
            $requestBodyHandler->getValidatedBody()
        );
    }

    public function testGetBodyFieldReturnsTheFieldPassedInTheParameter(): void
    {
        $fieldToValidateParts = ['user','name'];

        $requestBody = ['user' => ['name' => 'Nelson']];
        
        $requestBodyHandler = new RequestBodyHandler($requestBody);
        
        $bodyField = $requestBodyHandler->getBodyField($fieldToValidateParts);

        $this->assertSame(['name' => 'Nelson'], $bodyField);
    }

    public function testGetBodyFieldReturnsEmptyArrayIfFieldDoesNotExist(): void
    {
        $fieldToValidateParts = ['user','email'];

        $requestBody = ['user.name' => 'Nelson'];
        
        $requestBodyHandler = new RequestBodyHandler($requestBody);
        
        $bodyField = $requestBodyHandler->getBodyField($fieldToValidateParts);

        $this->assertEmpty($bodyField);
    }
}
