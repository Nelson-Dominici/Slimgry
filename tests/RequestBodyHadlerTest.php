<?php

namespace tests;

use PHPUnit\Framework\TestCase;
use NelsonDominici\Slimgry\RequestBodyHadler;

class RequestBodyHadlerTest extends TestCase
{
    public function testInitializationWithArrayResultsInArrayProperties(): void 
    {
        $requestBody = [
            'name' => 'Davidson', 
            'email' => 'Davidson123@gmail.com',
            'password' => '123456'
        ];

        $requestBodyHadler = new RequestBodyHadler($requestBody);

        $this->assertSame($requestBody, $requestBodyHadler->getRequestBody());
        $this->assertSame($requestBody, $requestBodyHadler->getValidatedBody());
    }

    public function testInitializationWithXMLResultsInArrayProperties(): void
    {
        $xmlString = '<?xml version="1.0" encoding="UTF-8"?>
        <user>
            <name>Davidson</name>
            <email>Davidson123@gmail.com</email>
            <password>123456</password>
        </user>';

        $expected = [
            'name' => 'Davidson', 
            'email' => 'Davidson123@gmail.com',
            'password' => '123456'
        ];

        $simpleXmlElement = new \SimpleXMLElement($xmlString);

        $requestBodyHadler = new RequestBodyHadler($simpleXmlElement);

        $this->assertSame($expected, $requestBodyHadler->getRequestBody());
        $this->assertSame($expected, $requestBodyHadler->getValidatedBody());
    }

    public function testMustHaveEmptyArrayPropertiesIfInitializedWithANull(): void
    {
        $requestBody = null;

        $requestBodyHadler = new RequestBodyHadler($requestBody);

        $this->assertEmpty($requestBodyHadler->getRequestBody());
        $this->assertEmpty($requestBodyHadler->getValidatedBody());
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
