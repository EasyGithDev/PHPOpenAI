<?php

namespace EasyGithDev\PHPOpenAI;

use EasyGithDev\PHPOpenAI\Helpers\ChatMessage;
use EasyGithDev\PHPOpenAI\Helpers\ModelEnum;
use EasyGithDev\PHPOpenAI\Validators\StatusValidator;
use PHPUnit\Framework\TestCase;

final class ChatTest extends TestCase
{

    public function testCreate()
    {

        $handler = (new OpenAIClient(getenv('OPENAI_API_KEY')))
            ->Chat()
            ->create(
                ModelEnum::GPT_3_5_TURBO,
                [
                    new ChatMessage(ChatMessage::ROLE_USER, 'Hello!'),
                ],
                user: 'phpunit'
            );

        $response = $handler->getResponse();
        $contentTypeValidator = $handler->getContentTypeValidator();

        $this->assertEquals(true, (new StatusValidator($response))->validate());
        $this->assertEquals(true, (new $contentTypeValidator($response))->validate());
    }
}
