<?php

namespace EasyGithDev\PHPOpenAI;

use EasyGithDev\PHPOpenAI\Models\ModelEnum;
use PHPUnit\Framework\TestCase;

final class CompletionTest extends TestCase
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
        $this->model = $openAIApi->Completion();

        parent::__construct();
    }

    public function testCreate()
    {
        $response = $this->model->create(
            ModelEnum::TEXT_DAVINCI_003,
            "Say this is a test",    
        );
        $json_response = json_decode($response);
        $text = $json_response->choices[0]->text;
        $this->assertEquals('This is indeed a test.', trim($text));
    }

   
}
