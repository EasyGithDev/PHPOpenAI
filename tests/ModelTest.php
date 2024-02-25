<?php

namespace EasyGithDev\PHPOpenAI;

use EasyGithDev\PHPOpenAI\Validators\ValidatorBuilder;
use PHPUnit\Framework\TestCase;

final class ModelTest extends TestCase
{



    public function testList()
    {
        $handler = (new OpenAIClient(getenv('OPENAI_API_KEY')))
        ->Model()
        ->list();
        
        $response = $handler->getResponse();
        $contentTypeValidator = $handler->getContentTypeValidator();

        $this->assertEquals(true, ValidatorBuilder::create('status', $response)->validate());
        $this->assertEquals(true, ValidatorBuilder::create($contentTypeValidator, $response)->validate());
    }

    public function testRetrieve()
    {
        $handler = (new OpenAIClient(getenv('OPENAI_API_KEY')))
        ->Model()
        ->retrieve('gpt-3.5-turbo-instruct');
        
        $response = $handler->getResponse();
        $contentTypeValidator = $handler->getContentTypeValidator();

        $this->assertEquals(true, ValidatorBuilder::create('status', $response)->validate());
        $this->assertEquals(true, ValidatorBuilder::create($contentTypeValidator, $response)->validate());
    }
}
