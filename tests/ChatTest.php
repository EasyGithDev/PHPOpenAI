<?php

namespace EasyGithDev\PHPOpenAI;

use EasyGithDev\PHPOpenAI\Chat\Message;
use PHPUnit\Framework\TestCase;

final class ChatTest extends TestCase
{
    protected $apiKey;
    protected $model;
    
    function __construct()
    {
        if (file_exists(Configuration::$_configDir . '/key.php')) {
            $this->apiKey = require Configuration::$_configDir . '/key.php';
        }
        $configuration = new Configuration($this->apiKey);
        $openAIApi = new OpenAIApi($configuration);
        $this->model = $openAIApi->ChatCompletion();

        parent::__construct();
    }

    public function testCreate()
    {

        $response =  $this->model->create(
            Model::GPT_3_5_TURBO,
            [
                new Message(Message::ROLE_USER, 'Hello!'),
            ]
        );
        $json_response = json_decode($response);
        $text = $json_response->choices[0]->message->content;
        $this->assertEquals('Hello there! How may I assist you today?', trim($text));
    }

   
}
