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
                </user>'
            )],
            [null]
        ];
    }

    #[DataProvider('requestBodyTypes')]
    public function testParseMethodReturnsArrayRegardlessOfRequestBodyType($requestBody): void 
    {
        $requestBodyHadler = new RequestBodyHadler($requestBody);

        $this->assertIsArray($requestBodyHadler->getValidatedBody());
    }
    
    public function testUpdateValidatedBodyUpdatesWhenParameterIsNotNull(): void
    {
        $newValidatedField = ['email' => 'new value'];
        
        $requestBodyHadler = new RequestBodyHadler(['name' => 'Davidson']);
        
        $requestBodyHadler->updateValidatedBody($newValidatedField);

        $this->assertSame(
            [
                'name' => 'Davidson',
                'email' => 'new value'
            ],
            $requestBodyHadler->getValidatedBody()
        );
    }

    public function testGetBodyFieldReturnsTheFieldPassedInTheParameter(): void
    {
        $fieldToValidateParts = ['user','name'];

        $requestBody = ['user' => ['name' => 'Nelson']];
        
        $requestBodyHadler = new RequestBodyHadler($requestBody);
        
        $bodyField = $requestBodyHadler->getBodyField($fieldToValidateParts);

        $this->assertSame(['name' => 'Nelson'], $bodyField);
    }

    public function testGetBodyFieldReturnsEmptyArrayIfFieldDoesNotExist(): void
    {
        $fieldToValidateParts = ['user','email'];

        $requestBody = ['user.name' => 'Nelson'];
        
        $requestBodyHadler = new RequestBodyHadler($requestBody);
        
        $bodyField = $requestBodyHadler->getBodyField($fieldToValidateParts);

        $this->assertEmpty($bodyField);
    }
}
