<?php
namespace EasyGithDev\PHPOpenAI;

class Image
{
    const API_URL = 'https://api.openai.com/v1/images/generations';
    const MAX_PROMPT_CHARS = 1000;

    protected Curl $curl;
    protected array $headers = [
        'Content-Type: application/json',
        'Authorization: Bearer ',
    ];

    function __construct(string $apiKey)
    {
        $this->curl = new Curl;
        $this->headers[1] = $this->headers[1] . $apiKey;
    }

    function create(string $prompt, int $n = 1, ImageSize $size = ImageSize::is1024, ResponseFormat $response_format = ResponseFormat::URL, string $user = ''): string
    {
        if (mb_strlen($prompt) > self::MAX_PROMPT_CHARS) {
            throw new \Exception("Max prompt is 1000 chars");
        }

        if ($n < 1 or $n > 10) {
            throw new \Exception('$n is between 1 and 10');
        }

        $response =  $this->curl
            ->setUrl(self::API_URL)
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
