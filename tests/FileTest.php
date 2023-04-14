<?php

namespace EasyGithDev\PHPOpenAI;

use EasyGithDev\PHPOpenAI\Validators\StatusValidator;
use PHPUnit\Framework\TestCase;

final class FileTest extends TestCase
{

    public function testList()
    {
        $handler = (new OpenAIClient(getenv('OPENAI_API_KEY')))
            ->File()
            ->list();

        $response = $handler->getResponse();
        $contentTypeValidator = $handler->getContentTypeValidator();

        $this->assertEquals(true, (new StatusValidator($response))->validate());
        $this->assertEquals(true, (new $contentTypeValidator($response))->validate());
    }

    public function testUpload(): string
    {
        $handler = (new OpenAIClient(getenv('OPENAI_API_KEY')))
            ->File()
            ->create(
                __DIR__ . '/../assets/mydata.jsonl',
                'fine-tune',
            );
        $response = $handler->getResponse();
        $contentTypeValidator = $handler->getContentTypeValidator();

        $this->assertEquals(true, (new StatusValidator($response))->validate());
        $this->assertEquals(true, (new $contentTypeValidator($response))->validate());
        return json_decode($response)->id;
    }

    /**
     * @depends testUpload
     */
    public function testRetrieve(string $file_id)
    {
        $this->assertStringStartsWith('file-', $file_id);
        $handler = (new OpenAIClient(getenv('OPENAI_API_KEY')))
            ->File()
            ->retrieve($file_id);

        $response = $handler->getResponse();
        $contentTypeValidator = $handler->getContentTypeValidator();

        $this->assertEquals(true, (new StatusValidator($response))->validate());
        $this->assertEquals(true, (new $contentTypeValidator($response))->validate());
        return $file_id;
    }

    /**
     * @depends testUpload
     */
    public function testDownload(string $file_id)
    {
        $this->assertStringStartsWith('file-', $file_id);
        $handler = (new OpenAIClient(getenv('OPENAI_API_KEY')))
            ->File()
            ->download($file_id);

        $response = $handler->getResponse();
        $contentTypeValidator = $handler->getContentTypeValidator();

        $this->assertEquals(true, (new StatusValidator($response))->validate());
        $this->assertEquals(true, (new $contentTypeValidator($response))->validate());
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
        $handler = (new OpenAIClient(getenv('OPENAI_API_KEY')))
            ->File()
            ->delete($file_id);

        $response = $handler->getResponse();
        $contentTypeValidator = $handler->getContentTypeValidator();

        $this->assertEquals(true, (new StatusValidator($response))->validate());
        $this->assertEquals(true, (new $contentTypeValidator($response))->validate());
    }
}
