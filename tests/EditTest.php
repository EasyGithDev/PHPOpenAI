<?php

namespace EasyGithDev\PHPOpenAI;

use EasyGithDev\PHPOpenAI\Helpers\ModelEnum;
use EasyGithDev\PHPOpenAI\Validators\ValidatorBuilder;
use PHPUnit\Framework\TestCase;

final class EditTest extends TestCase
{
    // public function testCreate()
    // {
    //     $handler = (new OpenAIClient(getenv('OPENAI_API_KEY')))->Edit()->create(
    //         instruction: "What day of the wek is it?",
    //         model: "gpt-3.5-turbo",
    //         input: "Fix the spelling mistakes",
    //     );

    //     $response = $handler->getResponse();
    //     $contentTypeValidator = $handler->getContentTypeValidator();

    //     $this->assertEquals(true, ValidatorBuilder::create('status', $response)->validate());
    //     $this->assertEquals(true, ValidatorBuilder::create($contentTypeValidator, $response)->validate());

    // }
}
