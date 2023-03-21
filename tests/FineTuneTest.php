<?php

namespace EasyGithDev\PHPOpenAI;

use PHPUnit\Framework\TestCase;

final class FineTuneTest extends TestCase
{
    protected $apiKey;
    protected $client;

    function __construct()
    {
        if (file_exists(Configuration::$_configDir . '/key.php')) {
            $this->apiKey = require Configuration::$_configDir . '/key.php';
        }
        $configuration = new Configuration($this->apiKey);
        $this->client = new OpenAIApi($configuration);

        parent::__construct();
    }

    public function testList()
    {
        $response = $this->client->FineTune()->list();
        $this->assertEquals(200, $response->getHttpCode());
    }

    public function testCreate()
    {
        $response = $this->client
            ->File()
            ->create(
                __DIR__ . '/../assets/mydata.jsonl',
                'fine-tune',
            );
        $file_id = $response->toObject()->id;


        $response = $this->client->FineTune()->create($file_id);
        $this->assertEquals(200, $response->getHttpCode());
        return $response->toObject()->id;
    }

    /**
     * @depends testCreate
     */
    public function testCancel($fine_tune_id)
    {
        $this->assertStringStartsWith('ft-', $fine_tune_id);
        $response = $this->client->FineTune()->cancel($fine_tune_id);
        $this->assertEquals(200, $response->getHttpCode());
        return $fine_tune_id;
    }

    /**
     * @depends testCancel
     */
    public function testRetrieve($fine_tune_id)
    {
        $this->assertStringStartsWith('ft-', $fine_tune_id);
        $response = $this->client->FineTune()->retrieve($fine_tune_id);
        $this->assertEquals(200, $response->getHttpCode());
        return $fine_tune_id;
    }

    /**
     * @depends testRetrieve
     */
    public function testListEvents($fine_tune_id)
    {
        $this->assertStringStartsWith('ft-', $fine_tune_id);
        $response = $this->client->FineTune()->listEvents($fine_tune_id);
        $this->assertEquals(200, $response->getHttpCode());
        return $fine_tune_id;
    }
}
