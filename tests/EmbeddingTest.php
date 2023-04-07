<?php

namespace EasyGithDev\PHPOpenAI;

use EasyGithDev\PHPOpenAI\Helpers\ModelEnum;
use PHPUnit\Framework\TestCase;

final class EmbeddingTest extends TestCase
{

    public function testCreate()
    {
        $response = (new OpenAIClient(getenv('OPENAI_API_KEY')))->Embedding()->create(
            ModelEnum::TEXT_EMBEDDING_ADA_002,
            "The food was delicious and the waiter...",
            user: 'phpunit'
        )->getResponse();

        $this->assertEquals(true, $response->isStatusOk());
        $this->assertEquals(true, $response->isContentTypeOk());
    }
}
