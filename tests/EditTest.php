<?php

namespace EasyGithDev\PHPOpenAI;

use EasyGithDev\PHPOpenAI\Helpers\ModelEnum;
use EasyGithDev\PHPOpenAI\Validators\StatusValidator;
use PHPUnit\Framework\TestCase;

final class EditTest extends TestCase
{
    public function testCreate()
    {
        $handler = (new OpenAIClient(getenv('OPENAI_API_KEY')))->Edit()->create(
            instruction: "What day of the wek is it?",
            model: ModelEnum::CODE_DAVINCI_EDIT_001,
            input: "Fix the spelling mistakes",
        );

        $response = $handler->getResponse();
        $contentTypeValidator = $handler->getContentTypeValidator();

        $this->assertEquals(true, (new StatusValidator($response))->validate());
        $this->assertEquals(true, (new $contentTypeValidator($response))->validate());

    }
}
