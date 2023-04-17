<?php

namespace EasyGithDev\PHPOpenAI;

use EasyGithDev\PHPOpenAI\Validators\ValidatorBuilder;
use PHPUnit\Framework\TestCase;

final class ModerationTest extends TestCase
{

    public function testCreate()
    {
        $handler = (new OpenAIClient(getenv('OPENAI_API_KEY')))
            ->Moderation()
            ->create(
                "I want to kill them.",
            );

        $response = $handler->getResponse();
        $contentTypeValidator = $handler->getContentTypeValidator();

        $this->assertEquals(true, ValidatorBuilder::create('status', $response)->validate());
        $this->assertEquals(true, ValidatorBuilder::create($contentTypeValidator, $response)->validate());
    }
}
