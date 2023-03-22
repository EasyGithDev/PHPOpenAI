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
        
        $configuration = new Configuration(getenv('OPENAI_API_KEY'));
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
        $this->assertEquals(200, $response->getHttpCode());
    }

   
}
