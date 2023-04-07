<?php

namespace EasyGithDev\PHPOpenAI;

use PHPUnit\Framework\TestCase;

final class FileTest extends TestCase
{

    public function testList()
    {
        $response = (new OpenAIClient(getenv('OPENAI_API_KEY')))
            ->File()
            ->list()
            ->getResponse();

        $this->assertEquals(true, $response->isStatusOk());
        $this->assertEquals(true, $response->isContentTypeOk());
    }

    public function testUpload(): string
    {
        $response = (new OpenAIClient(getenv('OPENAI_API_KEY')))
            ->File()
            ->create(
                __DIR__ . '/../assets/mydata.jsonl',
                'fine-tune',
            )->getResponse();
        $this->assertEquals(true, $response->isStatusOk());
        $this->assertEquals(true, $response->isContentTypeOk());
        return $response->toObject()->id;
    }

    /**
     * @depends testUpload
     */
    public function testRetrieve(string $file_id)
    {
        $this->assertStringStartsWith('file-', $file_id);
        $response = (new OpenAIClient(getenv('OPENAI_API_KEY')))
            ->File()
            ->retrieve($file_id)
            ->getResponse();
        $this->assertEquals(true, $response->isStatusOk());
        $this->assertEquals(true, $response->isContentTypeOk());
        return $file_id;
    }

    /**
     * @depends testUpload
     */
    public function testDownload(string $file_id)
    {
        $this->assertStringStartsWith('file-', $file_id);
        $response = (new OpenAIClient(getenv('OPENAI_API_KEY')))
            ->File()
            ->download($file_id)
            ->getResponse();
        $this->assertEquals(true, $response->isStatusOk());
        $this->assertEquals(true, $response->isContentTypeOk());
        $this->assertEquals(file_get_contents(__DIR__ . '/../assets/mydata.jsonl'), $response->getBody());
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
        $response = (new OpenAIClient(getenv('OPENAI_API_KEY')))->File()->delete($file_id)->getResponse();
        $this->assertEquals(true, $response->isStatusOk());
        $this->assertEquals(true, $response->isContentTypeOk());
    }
}
