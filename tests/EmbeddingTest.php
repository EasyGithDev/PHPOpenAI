<?php

namespace EasyGithDev\PHPOpenAI;

use EasyGithDev\PHPOpenAI\Helpers\ModelEnum;
use EasyGithDev\PHPOpenAI\Validators\ValidatorBuilder;
use PHPUnit\Framework\TestCase;

final class EmbeddingTest extends TestCase
{

    public function testCreate()
    {
        $handler = (new OpenAIClient(getenv('OPENAI_API_KEY')))->Embedding()->create(
            ModelEnum::TEXT_EMBEDDING_ADA_002,
            "The food was delicious and the waiter...",
            user: 'phpunit'
        );

        $response = $handler->getResponse();
        $contentTypeValidator = $handler->getContentTypeValidator();

        $this->assertEquals(true, ValidatorBuilder::create('status', $response)->validate());
        $this->assertEquals(true, ValidatorBuilder::create($contentTypeValidator, $response)->validate());
    }
}
