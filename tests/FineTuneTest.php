<?php

namespace EasyGithDev\PHPOpenAI;

use PHPUnit\Framework\TestCase;

final class FineTuneTest extends TestCase
{
    protected $apiKey;
    protected $model;
    protected $fine_tune_id = 'ft-0gPFDWV81vsXW1gLk4ztUX0h';

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

    // public function testCreate()
    // {
    //     $response = $this->model->create('file-TaUub0NiSnZ70YSgUoWqAS8K');
    //     $this->fine_tune_id = $response->toObject()->id;
    //     $this->assertEquals(200, $response->getHttpCode());
    // }

    public function testList()
    {
        $response = $this->model->list();
        $this->assertEquals(200, $response->getHttpCode());
    }

    public function testCancel()
    {
        $response = $this->model->cancel($this->fine_tune_id);
        $this->assertEquals(200, $response->getHttpCode());
    }

    public function testRetrieve()
    {
        $response = $this->model->retrieve($this->fine_tune_id);
        $this->assertEquals(200, $response->getHttpCode());
    }

    public function testListEvents()
    {
        $response = $this->model->listEvents($this->fine_tune_id);
        $this->assertEquals(200, $response->getHttpCode());
    }
}
