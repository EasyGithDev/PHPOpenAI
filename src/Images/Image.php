<?php

namespace EasyGithDev\PHPOpenAI\Images;

use EasyGithDev\PHPOpenAI\Curl;

class Image
{
    const MAX_PROMPT_CHARS = 1000;
    const END_POINT = '/images/generations';

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
    function create(string $prompt, int $n = 1, ImageSize $size = ImageSize::is1024, ResponseFormat $response_format = ResponseFormat::URL, string $user = ''): string
    {
        if (mb_strlen($prompt) > self::MAX_PROMPT_CHARS) {
            throw new \Exception("Max prompt is 1000 chars");
        }

        if ($n < 1 or $n > 10) {
            throw new \Exception('$n is between 1 and 10');
        }

        $response =  $this->curl
            ->setUrl($this->apiUrl . self::END_POINT)
            ->setHeaders(
                $this->headers
            )
            ->setPayload(
                [
                    "prompt" => "$prompt",
                    "n" => $n,
                    "size" => $size,
                    "response_format" => $response_format,
                ]
            )
            ->exec();

        $this->curl->close();

        return $response;
    }
}
