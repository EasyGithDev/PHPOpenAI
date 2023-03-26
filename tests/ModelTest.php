<?php

namespace EasyGithDev\PHPOpenAI;

use PHPUnit\Framework\TestCase;

final class ModelTest extends TestCase
{



    public function testList()
    {
        $response = (new OpenAIApi(getenv('OPENAI_API_KEY')))->Model()->list()->getResponse();
        $this->assertEquals(200, $response->getHttpCode());
    }

    public function testRetrieve()
    {
        $response = (new OpenAIApi(getenv('OPENAI_API_KEY')))->Model()->retrieve('text-davinci-003')->getResponse();
        $this->assertEquals(200, $response->getHttpCode());
    }
}
