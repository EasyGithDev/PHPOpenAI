<?php

namespace EasyGithDev\PHPOpenAI;

use PHPUnit\Framework\TestCase;

final class FileTest extends TestCase
{

    public function testList()
    {
        $response = (new OpenAIApi(getenv('OPENAI_API_KEY')))->File()->list()->getResponse();

        $this->assertEquals(200, $response->getHttpCode());
    }

    public function testUpload(): string
    {
        $response = (new OpenAIApi(getenv('OPENAI_API_KEY')))->File()->create(
            __DIR__ . '/../assets/mydata.jsonl',
            'fine-tune',
        )->getResponse();
        $this->assertEquals(200, $response->getHttpCode());
        return $response->toObject()->id;
    }

    /**
     * @depends testUpload
     */
    public function testRetrieve(string $file_id)
    {
        $this->assertStringStartsWith('file-', $file_id);
        $response = (new OpenAIApi(getenv('OPENAI_API_KEY')))->File()->retrieve($file_id)->getResponse();
        $this->assertEquals(200, $response->getHttpCode());
        return $file_id;
    }

    /**
     * @depends testUpload
     */
    public function testDelete(string $file_id)
    {
        // File is still processing. Check back later.
        sleep(10);

        $this->assertStringStartsWith('file-', $file_id);
        $response = (new OpenAIApi(getenv('OPENAI_API_KEY')))->File()->delete($file_id)->getResponse();
        $this->assertEquals(200, $response->getHttpCode());
    }
}
