<?php

namespace EasyGithDev\PHPOpenAI;

use PHPUnit\Framework\TestCase;

final class ModerationTest extends TestCase
{

    public function testCreate()
    {
        $response = (new OpenAIClient(getenv('OPENAI_API_KEY')))->Moderation()->create(
            "I want to kill them.",
        )->getResponse();

        $this->assertEquals(true, $response->isStatusOk());
        $this->assertEquals(true, $response->isContentTypeOk());
    }
}
