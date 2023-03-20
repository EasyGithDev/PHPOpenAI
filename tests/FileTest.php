<?php

namespace EasyGithDev\PHPOpenAI;

use PHPUnit\Framework\TestCase;

final class FileTest extends TestCase
{
    protected $apiKey;
    protected $model;

    function __construct()
    {
        if (file_exists(Configuration::$_configDir . '/key.php')) {
            $this->apiKey = require Configuration::$_configDir . '/key.php';
        }
        $configuration = new Configuration($this->apiKey);
        $openAIApi = new OpenAIApi($configuration);
        $this->model = $openAIApi->File();

        parent::__construct();
    }


    public function testList()
    {
        $response = $this->model->list();
        $this->assertEquals(200, $response->getHttpCode());
    }

    public function testUpload(): string
    {
        $response = $this->model->create(
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
        $response = $this->model->retrieve($file_id);
        $this->assertEquals(200, $response->getHttpCode());
        return $file_id;
    }

    /**
     * @depends testRetrieve
     */
    public function testDelete(string $file_id)
    {
        $response = $this->model->delete($file_id);
        $this->assertEquals(200, $response->getHttpCode());
    }
}
