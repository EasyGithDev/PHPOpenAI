<?php

namespace EasyGithDev\PHPOpenAI;

use PHPUnit\Framework\TestCase;

final class EditTest extends TestCase
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
        $this->model = $openAIApi->Edit();

        parent::__construct();
    }

    public function testCreate()
    {
        $response = $this->model->create(
            input: "What day of the wek is it?",
            instruction: "Fix the spelling mistakes",
        );
        $this->assertEquals(200, $response->getHttpCode());
    }

   
}
