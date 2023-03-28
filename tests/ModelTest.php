<?php

namespace EasyGithDev\PHPOpenAI;

use PHPUnit\Framework\TestCase;

final class ModelTest extends TestCase
{



    public function testList()
    {
        $response = (new OpenAIClient(getenv('OPENAI_API_KEY')))->Model()->list()->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testRetrieve()
    {
        $response = (new OpenAIClient(getenv('OPENAI_API_KEY')))->Model()->retrieve('text-davinci-003')->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
    }
}
