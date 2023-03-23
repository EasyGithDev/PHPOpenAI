<?php

namespace EasyGithDev\PHPOpenAI\Moderations;

use EasyGithDev\PHPOpenAI\Curl\CurlRequest;
use EasyGithDev\PHPOpenAI\Curl\CurlResponse;
use EasyGithDev\PHPOpenAI\Curl\Responses\ModerationResponse;

class Moderation
{
    public const END_POINT = '/moderations';




    /**
     * @param string $apiKey
     */
    public function __construct(protected CurlRequest $curl, protected CurlResponse $response)
    {
    }

    /**
     * @param string $input
     *
     * @return CurlResponse
     */
    public function create(string $input): ModerationResponse
    {
        if (empty($input)) {
            throw new \Exception("Input can not be empty");
        }

        $payload =  [
            "input" => $input,
        ];

        $response =  $this->curl
            ->setUrl(self::END_POINT)
            ->setMethod(CurlRequest::CURL_POST)
            ->setPayload(
                json_encode($payload)
            )
            ->setHeaders(['Content-Type: application/json'])
            ->exec();

        $this->curl->close();

        return $this->response->setInfos($response);
    }
}
