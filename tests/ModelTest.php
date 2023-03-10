<?php

namespace EasyGithDev\PHPOpenAI;

use PHPUnit\Framework\TestCase;

final class ModelTest extends TestCase
{
    public function testModel()
    {
        $apiKey = "XXXXXXX YOUR KEY";
        if (file_exists(Configuration::$_configDir . '/key.php')) {
            require Configuration::$_configDir . '/key.php';
        }

        $configuration = new Configuration($apiKey);
        $openAIApi = new OpenAIApi($configuration);
        $model = $openAIApi->Model();
        $response = $model->list();

        $json_response = json_decode($response);
        $id = $json_response->data[0]->id;
        $this->assertEquals('babbage', $id);
    }
}
