<?php

namespace EasyGithDev\PHPOpenAI;

use EasyGithDev\PHPOpenAI\Chats\Message;
use EasyGithDev\PHPOpenAI\Models\ModelEnum;
use PHPUnit\Framework\TestCase;

final class ChatTest extends TestCase
{

    public function testCreate()
    {

        $response = (new OpenAIApi(getenv('OPENAI_API_KEY')))->Chat()->create(
            ModelEnum::GPT_3_5_TURBO,
            [
                new Message(Message::ROLE_USER, 'Hello!'),
            ]
        )->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
    }
}
