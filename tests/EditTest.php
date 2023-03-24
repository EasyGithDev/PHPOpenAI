<?php

namespace EasyGithDev\PHPOpenAI;

use EasyGithDev\PHPOpenAI\Models\ModelEnum;
use PHPUnit\Framework\TestCase;

final class EditTest extends TestCase
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
        $response = $this->client->Edit()->create(
            instruction:"What day of the wek is it?",
            model:ModelEnum::CODE_DAVINCI_EDIT_001,
            input:"Fix the spelling mistakes",
        );
        $this->assertEquals(200, $response->getHttpCode());
    }
}
