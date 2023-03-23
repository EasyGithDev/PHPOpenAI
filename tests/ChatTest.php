<?php

namespace EasyGithDev\PHPOpenAI;

use EasyGithDev\PHPOpenAI\Chats\Message;
use EasyGithDev\PHPOpenAI\Models\ModelEnum;
use PHPUnit\Framework\TestCase;

final class ChatTest extends TestCase
{

    protected $client;

    function __construct()
    {

        $configuration = new Configuration(getenv('OPENAI_API_KEY'));
        $this->client = new OpenAIApi($configuration);

        parent::__construct();
    }

    public function testCreate()
    {

        $response =  $this->client->Chat()->create(
            ModelEnum::GPT_3_5_TURBO,
            [
                new Message(Message::ROLE_USER, 'Hello!'),
            ]
        );

        $this->assertEquals(200, $response->getHttpCode());

        sleep(10);

        $response =  $this->client->Chat()->create(
            "gpt-3.5-turbo",
            [
                new Message(Message::ROLE_USER, 'Hello!'),
            ]
        );

        $this->assertEquals(200, $response->getHttpCode());
    }

    public function testCreateFromString()
    {

        $response =  $this->client->Chat()->create(
            "gpt-3.5-turbo",
            [
                new Message(Message::ROLE_USER, 'Hello!'),
            ]
        );

        $this->assertEquals(200, $response->getHttpCode());
    }
}
