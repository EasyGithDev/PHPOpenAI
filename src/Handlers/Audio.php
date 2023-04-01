<?php

namespace EasyGithDev\PHPOpenAI\Handlers;

use EasyGithDev\PHPOpenAI\Exceptions\ClientException;
use EasyGithDev\PHPOpenAI\Helpers\ModelEnum;
use EasyGithDev\PHPOpenAI\Helpers\AudioResponseEnum;
use EasyGithDev\PHPOpenAI\Helpers\LanguageEnum;
use EasyGithDev\PHPOpenAI\OpenAIClient;
use EasyGithDev\PHPOpenAI\OpenAIHandler;

class Audio extends OpenAIHandler
{
    public const END_POINT = '/audio';

    /**
     * @param  protected
     */
    public function __construct(protected OpenAIClient $client)
    {
    }

    /**
     * @param string $filename
     *
     * @return bool
     */
    protected function extensionAvailable(string $filename): bool
    {
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        return in_array($ext, ['mp3', 'mp4', 'mpeg', 'mpga', 'm4a', 'wav', 'webm']);
    }

    /**
     * @param string $audioFile
     * @param ModelEnum $model
     * @param string $prompt
     * @param AudioResponseEnum $audioResponse
     * @param float $temperature
     * @param LanguageEnum $language
     *
     * @return self
     */
    public function transcription(string $audioFile, ModelEnum $model = ModelEnum::WHISPER_1, string $prompt = '', AudioResponseEnum $audioResponse = AudioResponseEnum::JSON, float $temperature = 0, LanguageEnum $language = LanguageEnum::ENGLISH): self
    {
        if (!file_exists($audioFile)) {
            throw new ClientException("Unable to locate file: $audioFile");
        }

        if (!$this->extensionAvailable($audioFile)) {
            throw new ClientException("Use one of these formats: mp3, mp4, mpeg, mpga, m4a, wav, or webm");
        }

        if ($model != ModelEnum::WHISPER_1) {
            throw new ClientException("Only whisper-1 is currently available.");
        }

        if ($temperature < 0 or $temperature > 1) {
            throw new ClientException("Temperature to use, between 0 and 1");
        }

        $payload = [
            "file" => curl_file_create($audioFile),
            "model" => $model->value,
            "prompt" => $prompt,
            "response_format" => $audioResponse->value,
            "temperature" => $temperature,
        ];

        if (!empty($language)) {
            $payload["LanguageEnum"] = $language->value;
        }

        $this->request = $this->client->post(
            self::END_POINT . '/transcriptions',
            $payload
        );

        return $this;
    }

    /**
     * @param string $audioFile
     * @param ModelEnum $model
     * @param string $prompt
     * @param AudioResponseEnum $audioResponse
     * @param float $temperature
     *
     * @return self
     */
    public function translation(string $audioFile, ModelEnum $model = ModelEnum::WHISPER_1, string $prompt = '', AudioResponseEnum $audioResponse = AudioResponseEnum::JSON, float $temperature = 0): self
    {
        if (!file_exists($audioFile)) {
            throw new ClientException("Unable to locate file: $audioFile");
        }

        if (!$this->extensionAvailable($audioFile)) {
            throw new ClientException("Use one of these formats: mp3, mp4, mpeg, mpga, m4a, wav, or webm");
        }

        if ($model != ModelEnum::WHISPER_1) {
            throw new ClientException("Only whisper-1 is currently available.");
        }

        if ($temperature < 0 or $temperature > 1) {
            throw new ClientException("Temperature to use, between 0 and 1");
        }

        $payload = [
            "file" => curl_file_create($audioFile),
            "model" => $model->value,
            "prompt" => $prompt,
            "response_format" => $audioResponse->value,
            "temperature" => $temperature,
        ];

        if (!empty($language)) {
            $payload["LanguageEnum"] = $language->value;
        }

        $this->request = $this->client->post(
            self::END_POINT . '/translations',
            $payload
        );

        return $this;
    }
}
