<?php

namespace EasyGithDev\PHPOpenAI;

use EasyGithDev\PHPOpenAI\Audios\ResponseFormat;
use EasyGithDev\PHPOpenAI\Chats\Message;
use EasyGithDev\PHPOpenAI\Models\ModelEnum;
use PHPUnit\Framework\TestCase;

final class AudioTest extends TestCase
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
        $this->model = $openAIApi->Audio();

        parent::__construct();
    }

    public function testTranscription()
    {

        $response = $this->model->transcription(
            __DIR__ . '/../assets/openai.mp3',
            ModelEnum::WHISPER_1,
            responseFormat: ResponseFormat::SRT
        );
        
        $this->assertEquals(200, $response->getHttpCode());
    }

    public function testTranslation()
    {
        $response = $this->model->translation(
            __DIR__ . '/../assets/openai_fr.mp3',
            ModelEnum::WHISPER_1,
            responseFormat: ResponseFormat::TEXT
        );
        
        $this->assertEquals(200, $response->getHttpCode());
    }

   
}
