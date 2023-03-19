<?php

namespace EasyGithDev\PHPOpenAI\Models;

use EasyGithDev\PHPOpenAI\Curl;
use EasyGithDev\PHPOpenAI\Response;

class Model
{
    const END_POINT = '/models';

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

    
    /**
     * @return Response
     */
    function list(): Response
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
     * @return Response
     */
    function retrieve(string $model): Response
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
