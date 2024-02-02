<?php

declare(strict_types=1);

namespace tests;

use PHPUnit\Framework\TestCase;
use NelsonDominici\Slimgry\RequestBodyHadler;
use PHPUnit\Framework\Attributes\DataProvider;

class RequestBodyHadlerTest extends TestCase
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
                </user>')
            ],
            [null]
        ];
    }

    #[DataProvider('requestBodyTypes')]
    public function testParseMethodReturnsAnArrayIndependentOfTheRequestBodyType($requestBody): void 
    {
        $requestBodyHadler = new RequestBodyHadler($requestBody);

        $this->assertIsArray($requestBodyHadler->getRequestBody());
        $this->assertIsArray($requestBodyHadler->getValidatedBody());
    }

    public function testMustPreserveValidatedBodyWhenUpdatingWithNullValue(): void
    {
        $requestBody = [
            'name' => 'Davidson', 
            'email' => 'Davidson123@gmail.com',
            'password' => '123456'
        ];

        $requestBodyHadler = new RequestBodyHadler($requestBody);
        $requestBodyHadler->updateValidatedBody(null);
        
        $this->assertSame($requestBody, $requestBodyHadler->getValidatedBody());
    }
    
    public function testUpdatesTheValidatedBodyWhenUpdatingWithAnArray(): void
    {
        $requestBody = [
            'name' => 'Davidson', 
            'email' => 'Davidson123@gmail.com',
            'password' => '123456'
        ];
        
        $newValidatedBody = ['expected' => 'This array is expected.'];
        
        $requestBodyHadler = new RequestBodyHadler($requestBody);
        
        $requestBodyHadler->updateValidatedBody($newValidatedBody);
        
        $this->assertSame($newValidatedBody, $requestBodyHadler->getValidatedBody());
    }
}
