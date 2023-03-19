<?php

namespace EasyGithDev\PHPOpenAI;

use EasyGithDev\PHPOpenAI\Models\ModelEnum;
use PHPUnit\Framework\TestCase;

final class EmbeddingTest extends TestCase
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
        $this->model = $openAIApi->Embedding();

        parent::__construct();
    }

    public function testCreate()
    {

        $response = $this->model->create(
            ModelEnum::TEXT_EMBEDDING_ADA_002,
            "The food was delicious and the waiter...",
        );
        
        $this->assertEquals(200, $response->getHttpCode());
    }


   
}
