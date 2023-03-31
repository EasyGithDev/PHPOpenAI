<?php

namespace EasyGithDev\PHPOpenAI;

use EasyGithDev\PHPOpenAI\Helpers\ModelEnum;
use PHPUnit\Framework\TestCase;

final class CompletionTest extends TestCase
{



    public function testCreate()
    {

        $response = (new OpenAIClient(getenv('OPENAI_API_KEY')))->Completion()->create(
            "text-davinci-003",
            "Say this is a test",
            user: 'phpunit'
        )->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
    }
}
