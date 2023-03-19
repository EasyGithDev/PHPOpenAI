<?php

namespace EasyGithDev\PHPOpenAI;

use PHPUnit\Framework\TestCase;

final class ModelTest extends TestCase
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
        $this->model = $openAIApi->Model();

        parent::__construct();
    }

    public function testList()
    {
        $response = $this->model->list();
        $this->assertEquals(200, $response->getHttpCode());
    }

    public function testRetrieve()
    {
        $response = $this->model->retrieve('text-davinci-003');
        $obj = $response->toObject();
        $id = $obj->id;
        $this->assertEquals('text-davinci-003', $id);
    }
}
