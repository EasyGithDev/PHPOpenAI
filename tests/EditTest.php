<?php

namespace EasyGithDev\PHPOpenAI;

use EasyGithDev\PHPOpenAI\Models\ModelEnum;
use PHPUnit\Framework\TestCase;

final class EditTest extends TestCase
{
    public function testCreate()
    {
        $response = (new OpenAIApi(getenv('OPENAI_API_KEY')))->Edit()->create(
            instruction: "What day of the wek is it?",
            model: ModelEnum::CODE_DAVINCI_EDIT_001,
            input: "Fix the spelling mistakes",
        )->getResponse();

        $this->assertEquals(200, $response->getHttpCode());
    }
}
