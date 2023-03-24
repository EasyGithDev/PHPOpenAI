<?php

namespace EasyGithDev\PHPOpenAI\Models;

use EasyGithDev\PHPOpenAI\Curl\CurlRequest;
use EasyGithDev\PHPOpenAI\Curl\CurlResponse;
use EasyGithDev\PHPOpenAI\Curl\Responses\ModelResponse;
use EasyGithDev\PHPOpenAI\OpenAIApi;
use EasyGithDev\PHPOpenAI\OpenAIModel;

class Model extends OpenAIModel
{
    public const END_POINT = '/models';

    /**
     * @param  protected
     */
    public function __construct(protected ?OpenAIApi $client = null)
    {
        $this->request = new CurlRequest();
        if (!is_null($this->client)) {
            $this->request->setBaseHeaders($this->client->getConfiguration()->getCurlHeaders())
                ->setBaseUrl($this->client->getConfiguration()->getApiUrl());
        }
        $this->response = new ModelResponse();
    }

    /**
     * @return CurlResponse
     */
    public function list(): ModelResponse
    {
        $response =  $this->request->setBaseHeaders($this->client->getConfiguration()->getCurlHeaders())
            ->setBaseUrl($this->client->getConfiguration()->getApiUrl())
            ->setUrl(self::END_POINT)
            ->exec();

        $this->request->close();

        return $this->response->setInfos($response);
    }


    /**
     * @param string $model
     *
     * @return CurlResponse
     */
    public function retrieve(string $model): CurlResponse
    {
        $response =  $this->request->setBaseHeaders($this->client->getConfiguration()->getCurlHeaders())
            ->setBaseUrl($this->client->getConfiguration()->getApiUrl())
            ->setUrl(self::END_POINT . "/$model")
            ->setHeaders(['Content-Type: application/json'])
            ->exec();

        $this->request->close();

        return $this->response->setInfos($response);
    }

    public function delete(string $model): CurlResponse
    {
        $response =  $this->request
            ->setUrl(self::END_POINT . "/$model")
            ->setMethod(CurlRequest::CURL_DELETE)
            ->exec();

        $this->request->close();

        return $this->response->setInfos($response);
    }
}
