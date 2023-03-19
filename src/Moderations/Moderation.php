<?php

namespace EasyGithDev\PHPOpenAI\Moderations;

use EasyGithDev\PHPOpenAI\Curl\CurlRequest;
use EasyGithDev\PHPOpenAI\Curl\CurlResponse;


class Moderation
{
    const END_POINT = '/moderations';

    protected CurlRequest $curl;


    /**
     * @param string $apiKey
     */
    function __construct(CurlRequest $curl)
    {
        $this->curl = $curl;
       
    }

    /**
     * @param string $input
     * 
     * @return CurlResponse
     */
    function create(string $input): CurlResponse
    {
        if (empty($input)) {
            throw new \Exception("Input can not be empty");
        }

        $payload =  [
            "input" => $input,
        ];
        
        $response =  $this->curl
            ->appendToUrl(self::END_POINT)
            ->setPayload(
                json_encode($payload)
            )
            ->exec();

        $this->curl->close();

        return $response;
    }
}
