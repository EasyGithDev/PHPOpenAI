<?php

namespace EasyGithDev\PHPOpenAI;

use PHPUnit\Framework\TestCase;

final class FileTest extends TestCase
{
    protected $client;

    function __construct()
    {
        $configuration = new Configuration(getenv('OPENAI_API_KEY'));
        $this->client = new OpenAIApi($configuration);

        parent::__construct();
    }

    public function testList()
    {
        $response = $this->client->File()->list();
        $this->assertEquals(200, $response->getHttpCode());
    }

    public function testUpload(): string
    {
        $response = $this->client->File()->create(
            __DIR__ . '/../assets/mydata.jsonl',
            'fine-tune',
        );
        $this->assertEquals(200, $response->getHttpCode());
        return $response->toObject()->id;
    }

    /**
     * @depends testUpload
     */
    public function testRetrieve(string $file_id)
    {
        $this->assertStringStartsWith('file-', $file_id);
        $response = $this->client->File()->retrieve($file_id);
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
        $response = $this->client->File()->delete($file_id);
        $this->assertEquals(200, $response->getHttpCode());
    }
}
