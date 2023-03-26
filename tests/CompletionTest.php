<?php

namespace EasyGithDev\PHPOpenAI;

use EasyGithDev\PHPOpenAI\Models\ModelEnum;
use PHPUnit\Framework\TestCase;

final class CompletionTest extends TestCase
{



    public function testCreate()
    {

        $response = (new OpenAIApi(getenv('OPENAI_API_KEY')))->Completion()->create(
            "text-davinci-003",
            "Say this is a test",
        )->getResponse();


        $this->assertEquals(200, $response->getHttpCode());
    }
}
