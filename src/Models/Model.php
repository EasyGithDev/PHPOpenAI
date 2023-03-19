<?php

namespace EasyGithDev\PHPOpenAI\Models;

use EasyGithDev\PHPOpenAI\Curl\CurlRequest;
use EasyGithDev\PHPOpenAI\Curl\CurlResponse;


class Model
{
    const END_POINT = '/models';

    protected CurlRequest $curl;


    /**
     * @param string $apiKey
     */
    function __construct(CurlRequest $curl)
    {
        $this->curl = $curl;
       
    }

    
    /**
     * @return CurlResponse
     */
    function list(): CurlResponse
    {
        $response =  $this->curl
            ->appendToUrl(self::END_POINT)
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
            ->appendToUrl(self::END_POINT . "/$model")
            ->exec();

        $this->curl->close();

        return $response;
    }
}
