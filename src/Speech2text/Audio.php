<?php

namespace EasyGithDev\PHPOpenAI\Speech2text;

use EasyGithDev\PHPOpenAI\Curl;
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

    /**
     * @param string $prompt
     * @param int $n
     * @param ImageSize $size
     * @param ResponseFormat $response_format
     * @param string $user
     * 
     * @return string
     */
    function transcription(string $model,  string $audioFile): string
    {
        if (!file_exists($audioFile)) {
            throw new Exception("Unable to locate file: $audioFile");
        }

        $payload = [
            "file" => curl_file_create($audioFile),
            "model" => $model,
        ];

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
