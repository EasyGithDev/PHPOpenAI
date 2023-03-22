<?php

namespace EasyGithDev\PHPOpenAI;

use EasyGithDev\PHPOpenAI\Chats\Message;
use EasyGithDev\PHPOpenAI\Models\ModelEnum;
use PHPUnit\Framework\TestCase;

final class ChatTest extends TestCase
{
    
    protected $model;
    
    function __construct()
    {
        
        $configuration = new Configuration(getenv('OPENAI_API_KEY'));
        $openAIApi = new OpenAIApi($configuration);
        $this->model = $openAIApi->Chat();

        parent::__construct();
    }

    public function testCreate()
    {

        $response =  $this->model->create(
            ModelEnum::GPT_3_5_TURBO,
            [
                new Message(Message::ROLE_USER, 'Hello!'),
            ]
        );
        
        $this->assertEquals(200, $response->getHttpCode());
    }

   
}
