<?php

namespace EasyGithDev\PHPOpenAI\Audios;

use EasyGithDev\PHPOpenAI\Curl\CurlRequest;
use EasyGithDev\PHPOpenAI\Models\ModelEnum;
use EasyGithDev\PHPOpenAI\Curl\CurlResponse;
use EasyGithDev\PHPOpenAI\Curl\Responses\AudioResponse;
use Exception;

class Audio
{
    public const END_POINT = '/audio';

    /**
     * @param string $apiUrl
     * @param array $headers
     */
    public function __construct(protected CurlRequest $curl, protected CurlResponse $response)
    {
    }

    protected function extensionAvailable(string $filename): bool
    {
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        return in_array($ext, ['mp3', 'mp4', 'mpeg', 'mpga', 'm4a', 'wav', 'webm']);
    }

    public function transcription(
        string $audioFile,
        ModelEnum $model = ModelEnum::WHISPER_1,
        string $prompt = '',
        ResponseFormat $responseFormat = ResponseFormat::JSON,
        float $temperature = 0,
        Language $language = Language::ENGLISH
    ): AudioResponse {
        if (!file_exists($audioFile)) {
            throw new Exception("Unable to locate file: $audioFile");
        }

        if (!$this->extensionAvailable($audioFile)) {
            throw new Exception("Use one of these formats: mp3, mp4, mpeg, mpga, m4a, wav, or webm");
        }

        if ($model != ModelEnum::WHISPER_1) {
            throw new \Exception("Only whisper-1 is currently available.");
        }

        if ($temperature < 0 or $temperature > 1) {
            throw new \Exception("Temperature to use, between 0 and 1");
        }

        $payload = [
            "file" => curl_file_create($audioFile),
            "model" => $model->value,
            "prompt" => $prompt,
            "response_format" => $responseFormat->value,
            "temperature" => $temperature,
        ];

        if (!empty($language)) {
            $payload["language"] = $language->value;
        }

        $response =  $this->curl
            ->setUrl(self::END_POINT . '/transcriptions')
            ->setMethod(CurlRequest::CURL_POST)
            ->setPayload($payload)
            ->exec();

        $this->curl->close();

        return $this->response->setInfos($response);
    }

    public function translation(
        string $audioFile,
        ModelEnum $model = ModelEnum::WHISPER_1,
        string $prompt = '',
        ResponseFormat $responseFormat = ResponseFormat::JSON,
        float $temperature = 0
    ): AudioResponse {
        if (!file_exists($audioFile)) {
            throw new Exception("Unable to locate file: $audioFile");
        }

        if (!$this->extensionAvailable($audioFile)) {
            throw new Exception("Use one of these formats: mp3, mp4, mpeg, mpga, m4a, wav, or webm");
        }

        if ($model != ModelEnum::WHISPER_1) {
            throw new \Exception("Only whisper-1 is currently available.");
        }

        if ($temperature < 0 or $temperature > 1) {
            throw new \Exception("Temperature to use, between 0 and 1");
        }

        $payload = [
            "file" => curl_file_create($audioFile),
            "model" => $model->value,
            "prompt" => $prompt,
            "response_format" => $responseFormat->value,
            "temperature" => $temperature,
        ];

        if (!empty($language)) {
            $payload["language"] = $language->value;
        }

        $response =  $this->curl
            ->setUrl(self::END_POINT . '/translations')
            ->setMethod(CurlRequest::CURL_POST)
            ->setPayload($payload)
            ->exec();

        $this->curl->close();

        return $this->response->setInfos($response);
    }
}
