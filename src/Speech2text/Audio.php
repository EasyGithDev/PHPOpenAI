<?php

namespace EasyGithDev\PHPOpenAI\Speech2text;

use EasyGithDev\PHPOpenAI\Curl;
use EasyGithDev\PHPOpenAI\Model;
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


    /*
    The audio file to transcribe, in one of these formats: mp3, mp4, mpeg, mpga, m4a, wav, or webm.

    model
    string
    Required
    ID of the model to use. Only whisper-1 is currently available.
    
    prompt
    string
    Optional
    An optional text to guide the model's style or continue a previous audio segment. The prompt should match the audio language.
    
    response_format
    string
    Optional
    Defaults to json
    The format of the transcript output, in one of these options: json, text, srt, verbose_json, or vtt.
    
    temperature
    number
    Optional
    Defaults to 0
    The sampling temperature, between 0 and 1. Higher values like 0.8 will make the output more random, while lower values like 0.2 will make it more focused and deterministic. If set to 0, the model will use log probability to automatically increase the temperature until certain thresholds are hit.
    
    language
    string
    Optional
    The language of the input audio. Supplying the input language in ISO-639-1 format will improve accuracy and latency.
*/

    function transcription(string $audioFile, Model $model, string $prompt = '', ResponseFormat $responseFormat = ResponseFormat::JSON, float $temperature = 0, string $language = ''): string
    {
        if (!file_exists($audioFile)) {
            throw new Exception("Unable to locate file: $audioFile");
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
            $payload["language"] = $language;
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
}
