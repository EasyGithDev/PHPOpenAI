<?php

namespace EasyGithDev\PHPOpenAI;

use EasyGithDev\PHPOpenAI\Helpers\AudioResponseEnum;
use EasyGithDev\PHPOpenAI\Helpers\ModelEnum;
use EasyGithDev\PHPOpenAI\Validators\StatusValidator;
use PHPUnit\Framework\TestCase;

final class AudioTest extends TestCase
{

    public function testTranscription()
    {
        $handler = (new OpenAIClient(getenv('OPENAI_API_KEY')))->Audio()
            ->addCurlParam('timeout', 30)
            ->transcription(
                __DIR__ . '/../assets/openai.mp3',
                ModelEnum::WHISPER_1,
                response_format: AudioResponseEnum::SRT
            );

        $response = $handler->getResponse();
        $contentTypeValidator = $handler->getContentTypeValidator();

        $this->assertEquals(true, (new StatusValidator($response))->validate());
        $this->assertEquals(true, (new $contentTypeValidator($response))->validate());
    }

    public function testTranslation()
    {
        $handler = (new OpenAIClient(getenv('OPENAI_API_KEY')))->Audio()
            ->addCurlParam('timeout', 30)
            ->translation(
                __DIR__ . '/../assets/openai_fr.mp3',
                ModelEnum::WHISPER_1,
                response_format: AudioResponseEnum::TEXT
            );

        $response = $handler->getResponse();
        $contentTypeValidator = $handler->getContentTypeValidator();

        $this->assertEquals(true, (new StatusValidator($response))->validate());
        $this->assertEquals(true, (new $contentTypeValidator($response))->validate());
    }
}
