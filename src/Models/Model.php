<?php

namespace EasyGithDev\PHPOpenAI\Models;

use EasyGithDev\PHPOpenAI\Curl\CurlRequest;
use EasyGithDev\PHPOpenAI\Curl\CurlResponse;
use EasyGithDev\PHPOpenAI\Curl\Responses\ModelResponse;

class Model
{
    const END_POINT = '/models';

    /**
     * @param string $apiKey
     */
    function __construct(protected CurlRequest $curl, protected CurlResponse $response)
    {
    }

    /**
     * @return CurlResponse
     */
    function list(): ModelResponse
    {
        $response =  $this->curl
            ->setUrl(self::END_POINT)
            ->exec();

        $this->curl->close();

        return $this->response->setInfos($response);
    }


    /**
     * @param string $model
     * 
     * @return CurlResponse
     */
    function retrieve(string $model): CurlResponse
    {
        $response =  $this->curl
            ->setUrl(self::END_POINT . "/$model")
            ->setHeaders(['Content-Type: application/json'])
            ->exec();

        $this->curl->close();

        return $this->response->setInfos($response);
    }

    function delete(string $model): CurlResponse
    {
        $response =  $this->curl
            ->setUrl(self::END_POINT . "/$model")
            ->setMethod(CurlRequest::CURL_DELETE)
            ->exec();

        $this->curl->close();

        return $this->response->setInfos($response);
    }
}
