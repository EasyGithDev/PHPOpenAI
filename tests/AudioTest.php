<?php

namespace EasyGithDev\PHPOpenAI;

use EasyGithDev\PHPOpenAI\Helpers\AudioResponseEnum;
use EasyGithDev\PHPOpenAI\Helpers\ModelEnum;
use PHPUnit\Framework\TestCase;

final class AudioTest extends TestCase
{

    public function testTranscription()
    {

        $response = (new OpenAIClient(getenv('OPENAI_API_KEY')))->Audio()->transcription(
            __DIR__ . '/../assets/openai.mp3',
            ModelEnum::WHISPER_1,
            audioResponse: AudioResponseEnum::SRT
        )->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testTranslation()
    {
        $response = (new OpenAIClient(getenv('OPENAI_API_KEY')))->Audio()->translation(
            __DIR__ . '/../assets/openai_fr.mp3',
            ModelEnum::WHISPER_1,
            audioResponse: AudioResponseEnum::TEXT
        )->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
    }
}
