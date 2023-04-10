<?php

namespace EasyGithDev\PHPOpenAI;

use EasyGithDev\PHPOpenAI\Validators\StatusValidator;
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

        $this->assertEquals(true, (new StatusValidator($response))->validate());
        $this->assertEquals(true, (new $contentTypeValidator($response))->validate());
    }

    public function testRetrieve()
    {
        $handler = (new OpenAIClient(getenv('OPENAI_API_KEY')))
        ->Model()
        ->retrieve('text-davinci-003');
        
        $response = $handler->getResponse();
        $contentTypeValidator = $handler->getContentTypeValidator();

        $this->assertEquals(true, (new StatusValidator($response))->validate());
        $this->assertEquals(true, (new $contentTypeValidator($response))->validate());
    }
}
