<?php

namespace EasyGithDev\PHPOpenAI;

use EasyGithDev\PHPOpenAI\Helpers\ChatMessage;
use EasyGithDev\PHPOpenAI\Helpers\ModelEnum;
use PHPUnit\Framework\TestCase;

final class ChatTest extends TestCase
{

    public function testCreate()
    {

        $response = (new OpenAIClient(getenv('OPENAI_API_KEY')))->Chat()->create(
            ModelEnum::GPT_3_5_TURBO,
            [
                new ChatMessage(ChatMessage::ROLE_USER, 'Hello!'),
            ]
        )->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
    }
}
