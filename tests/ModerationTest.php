<?php

namespace EasyGithDev\PHPOpenAI;

use PHPUnit\Framework\TestCase;

final class ModerationTest extends TestCase
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
        $this->model = $openAIApi->Moderation();

        parent::__construct();
    }

    public function testCreate()
    {
        $response = $this->model->create(
            input: "I want to kill them.",
        );
        $json_response = json_decode($response);
        $text = $json_response->results[0]->flagged;
        $this->assertEquals(1, trim($text));
    }

   
}
