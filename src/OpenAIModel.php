<?php

namespace EasyGithDev\PHPOpenAI;

use EasyGithDev\PHPOpenAI\Curl\CurlRequest;
use EasyGithDev\PHPOpenAI\Curl\CurlResponse;
use EasyGithDev\PHPOpenAI\Exceptions\ClientException;
use stdClass;

abstract class OpenAIModel
{
    protected ?CurlRequest $request = null;
    protected ?CurlResponse $response = null;
    protected ?OpenAIApi $client = null;

    /**
     * @param CurlRequest $request
     * 
     * @return void
     */
    public function setRequest(CurlRequest $request): void
    {
        $this->request = $request;
        $this->response = null;
    }

    /**
     * @return CurlRequest
     */
    public function getRequest(): CurlRequest
    {
        if (\is_null($this->request)) {
            throw new ClientException('Request not configured.');
        }
        return $this->request;
    }

    /**
     * @return CurlResponse
     */
    public function getResponse(): CurlResponse
    {
        if (!\is_null($this->response)) {
            return $this->response;
        }

        $this->response = $this->client->sendRequest($this->getRequest());
        $this->request = null;
        return $this->response;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->getResponse()->throwable()->toArray();
    }

    /**
     * @return stdClass
     */
    public function toObject(): stdClass
    {
        return $this->getResponse()->throwable()->toObject();
    }
}
