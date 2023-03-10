<?php

namespace EasyGithDev\PHPOpenAI\Moderations;

use EasyGithDev\PHPOpenAI\Curl;

class Moderation
{
    const END_POINT = '/moderations';

    protected Curl $curl;
    protected string $apiUrl;
    protected array $headers = [];

    /**
     * @param string $apiKey
     */
    function __construct(string $apiUrl, array $headers)
    {
        $this->curl = new Curl;
        $this->apiUrl = $apiUrl;
        $this->headers = $headers;
    }

    function create(string $input): string
    {
        if (empty($input)) {
            throw new \Exception("Input can not be empty");
        }

        $payload =  [
            "input" => $input,
        ];
        
        $response =  $this->curl
            ->setUrl($this->apiUrl . self::END_POINT)
            ->setHeaders(
                $this->headers
            )
            ->setPayload(
                json_encode($payload)
            )
            ->exec();

        $this->curl->close();

        return $response;
    }
}
