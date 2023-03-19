<?php

namespace EasyGithDev\PHPOpenAI\Audios;

use EasyGithDev\PHPOpenAI\Curl;
use EasyGithDev\PHPOpenAI\Models\ModelEnum;
use EasyGithDev\PHPOpenAI\Response;
use Exception;

class Audio
{
    const END_POINT = '/audio';

    protected Curl $curl;
    protected string $apiUrl;
    protected array $headers = [];

    /**
     * @param string $apiUrl
     * @param array $headers
     */
    function __construct(string $apiUrl, array $headers)
    {
        $this->curl = new Curl;
        $this->apiUrl = $apiUrl;
        $this->headers = $headers;
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
    ): Response {
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
            ->setUrl($this->apiUrl . self::END_POINT . '/transcriptions')
            ->setHeaders(
                $this->headers
            )
            ->setPayload($payload)
            ->exec();

        $this->curl->close();

        return $response;
    }

    public function translation(
        string $audioFile,
        ModelEnum $model = ModelEnum::WHISPER_1,
        string $prompt = '',
        ResponseFormat $responseFormat = ResponseFormat::JSON,
        float $temperature = 0
    ): Response {
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
            ->setUrl($this->apiUrl . self::END_POINT . '/translations')
            ->setHeaders(
                $this->headers
            )
            ->setPayload($payload)
            ->exec();

        $this->curl->close();

        return $response;
    }
}
