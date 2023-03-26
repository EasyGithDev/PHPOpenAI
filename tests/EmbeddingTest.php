<?php

namespace EasyGithDev\PHPOpenAI;

use EasyGithDev\PHPOpenAI\Models\ModelEnum;
use PHPUnit\Framework\TestCase;

final class EmbeddingTest extends TestCase
{

    public function testCreate()
    {
        $response = (new OpenAIApi(getenv('OPENAI_API_KEY')))->Embedding()->create(
            ModelEnum::TEXT_EMBEDDING_ADA_002,
            "The food was delicious and the waiter...",
        )->getResponse();

        $this->assertEquals(200, $response->getHttpCode());
    }
}
