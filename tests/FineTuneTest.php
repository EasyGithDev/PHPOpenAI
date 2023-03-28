<?php

namespace EasyGithDev\PHPOpenAI;

use PHPUnit\Framework\TestCase;

final class FineTuneTest extends TestCase
{

    public function testList()
    {
        $response =  (new OpenAIClient(getenv('OPENAI_API_KEY')))->FineTune()
            ->list()->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testCreate()
    {
        $file_id =   (new OpenAIClient(getenv('OPENAI_API_KEY')))
            ->File()
            ->create(
                __DIR__ . '/../assets/mydata.jsonl',
                'fine-tune',
            )->toObject()->id;

        $response =  (new OpenAIClient(getenv('OPENAI_API_KEY')))->FineTune()
            ->create($file_id)->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        return $response->toObject()->id;
    }

    /**
     * @depends testCreate
     */
    public function testRetrieve($fine_tune_id)
    {
        $this->assertStringStartsWith('ft-', $fine_tune_id);
        $response =  (new OpenAIClient(getenv('OPENAI_API_KEY')))->FineTune()
            ->retrieve($fine_tune_id)->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        return $fine_tune_id;
    }

    /**
     * @depends testRetrieve
     */
    public function testListEvents($fine_tune_id)
    {
        $this->assertStringStartsWith('ft-', $fine_tune_id);
        $response =  (new OpenAIClient(getenv('OPENAI_API_KEY')))->FineTune()
            ->listEvents($fine_tune_id)->getResponse();;
        $this->assertEquals(200, $response->getStatusCode());
        return $fine_tune_id;
    }

    /**
     * @depends testRetrieve
     */
    public function testCancel($fine_tune_id)
    {
        $this->assertStringStartsWith('ft-', $fine_tune_id);
        $response =  (new OpenAIClient(getenv('OPENAI_API_KEY')))->FineTune()
            ->cancel($fine_tune_id)->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        return $fine_tune_id;
    }
}
