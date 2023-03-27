<?php

namespace EasyGithDev\PHPOpenAI;

use EasyGithDev\PHPOpenAI\Audios\ResponseFormat;
use EasyGithDev\PHPOpenAI\Chats\Message;
use EasyGithDev\PHPOpenAI\Models\ModelEnum;
use PHPUnit\Framework\TestCase;

final class AudioTest extends TestCase
{

    public function testTranscription()
    {

        $response = (new OpenAIApi(getenv('OPENAI_API_KEY')))->Audio()->transcription(
            __DIR__ . '/../assets/openai.mp3',
            ModelEnum::WHISPER_1,
            responseFormat: ResponseFormat::SRT
        )->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testTranslation()
    {
        $response = (new OpenAIApi(getenv('OPENAI_API_KEY')))->Audio()->translation(
            __DIR__ . '/../assets/openai_fr.mp3',
            ModelEnum::WHISPER_1,
            responseFormat: ResponseFormat::TEXT
        )->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
    }
}
