<?php

namespace EasyGithDev\PHPOpenAI;

use PHPUnit\Framework\TestCase;

final class FineTuneTest extends TestCase
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
        $this->model = $openAIApi->FineTune();

        parent::__construct();
    }

    public function testList()
    {
        $response = $this->model->list();
        $this->assertEquals(200, $response->getHttpCode());
    }

    public function testCreate()
    {
        $this->assertTrue(false);
        // $response = $this->model->create('file-TaUub0NiSnZ70YSgUoWqAS8K');
        // $this->assertEquals(200, $response->getHttpCode());
        // return $response->toObject()->id;
        return '';
    }

    /**
     * @depends testCreate
     */
    public function testCancel($fine_tune_id)
    {
        $this->assertStringStartsWith('ft-', $fine_tune_id);
        $response = $this->model->cancel($fine_tune_id);
        $this->assertEquals(200, $response->getHttpCode());
        return $fine_tune_id;
    }

    /**
     * @depends testCancel
     */
    public function testRetrieve($fine_tune_id)
    {
        $this->assertStringStartsWith('ft-', $fine_tune_id);
        $response = $this->model->retrieve($fine_tune_id);
        $this->assertEquals(200, $response->getHttpCode());
        return $fine_tune_id;
    }

    /**
     * @depends testRetrieve
     */
    public function testListEvents($fine_tune_id)
    {
        $this->assertStringStartsWith('ft-', $fine_tune_id);
        $response = $this->model->listEvents($fine_tune_id);
        $this->assertEquals(200, $response->getHttpCode());
        return $fine_tune_id;
    }
}
