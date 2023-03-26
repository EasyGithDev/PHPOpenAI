<?php

namespace EasyGithDev\PHPOpenAI;

use EasyGithDev\PHPOpenAI\Curl\CurlRequest;
use EasyGithDev\PHPOpenAI\Curl\CurlResponse;
use EasyGithDev\PHPOpenAI\Exceptions\ClientException;

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
    private function parseResponse(CurlResponse $response): array
    {
        $contentType = \strtolower($response->getHeaderLine('Content-Type'));
        if (substr($contentType, 0, 16) !== 'application/json' && \strlen($contentType) !== 0) {
            throw new ClientException(\sprintf('Unsupported content type: %s', $contentType));
        }

        $body = (string) $response->getBody();
        $body = \strlen($body) === 0 ? '[]' : $body;
        $data = (array) \json_decode($body, true);

        if (\json_last_error()) {
            throw new ClientException(
                'Failed to parse JSON response body: ' . \json_last_error_msg()
            );
        }
        return $data;
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

   
    public function toModel(): mixed
    {
      
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->parseResponse($this->getResponse());
    }

}
