<?php

namespace EasyGithDev\PHPOpenAI;

use PHPUnit\Framework\TestCase;

final class EditTest extends TestCase
{
    
    protected $model;
    
    function __construct()
    {
        
        $configuration = new Configuration(getenv('OPENAI_API_KEY'));
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
