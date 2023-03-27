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
     * @param CurlResponse $response
     * 
     * @return array
     */
    private function parseResponse(CurlResponse $response): string
    {
        $contentType = \strtolower($response->getHeaderLine('Content-Type'));
        if (substr($contentType, 0, 16) !== 'application/json' && \strlen($contentType) !== 0) {
            throw new ClientException(\sprintf('Unsupported content type: %s', $contentType));
        }

        return (string) $response->getBody();
    }

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
        return json_decode($this->parseResponse($this->getResponse()), true);
    }

    /**
     * @return stdClass
     */
    public function toObject(): stdClass
    {
        return json_decode($this->parseResponse($this->getResponse()));
    }

}
