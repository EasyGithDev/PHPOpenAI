<?php

namespace EasyGithDev\PHPOpenAI\Models;

use EasyGithDev\PHPOpenAI\Curl\CurlRequest;
use EasyGithDev\PHPOpenAI\Curl\CurlResponse;


class Model
{
    const END_POINT = '/models';

    protected CurlRequest $curl;
    protected string $apiUrl;
    protected array $headers = [];

    /**
     * @param string $apiKey
     */
    function __construct(string $apiUrl, array $headers)
    {
        $this->curl = new CurlRequest;
        $this->apiUrl = $apiUrl;
        $this->headers = $headers;
    }

    
    /**
     * @return CurlResponse
     */
    function list(): CurlResponse
    {
        $response =  $this->curl
            ->setUrl($this->apiUrl . self::END_POINT)
            ->setHeaders(
                $this->headers
            )
            ->exec();

        $this->curl->close();

        return $response;
    }


    /**
     * @param string $model
     * 
     * @return CurlResponse
     */
    function retrieve(string $model): CurlResponse
    {
        $response =  $this->curl
            ->setUrl($this->apiUrl . self::END_POINT . "/$model")
            ->setHeaders(
                $this->headers
            )
            ->exec();

        $this->curl->close();

        return $response;
    }
}
