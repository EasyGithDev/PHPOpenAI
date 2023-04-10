<?php

namespace EasyGithDev\PHPOpenAI;

use EasyGithDev\PHPOpenAI\Curl\CurlRequest;
use EasyGithDev\PHPOpenAI\Curl\CurlResponse;
use EasyGithDev\PHPOpenAI\Exceptions\ApiException;
use EasyGithDev\PHPOpenAI\Exceptions\ClientException;
use EasyGithDev\PHPOpenAI\Validators\ApplicationJsonValidator;
use EasyGithDev\PHPOpenAI\Validators\StatusValidator;

/**
 * [Description OpenAIHandler]
 */
abstract class OpenAIHandler
{
    /**
     * @var CurlRequest|null|null
     */
    protected ?CurlRequest $request = null;

    /**
     * @var CurlResponse|null|null
     */
    protected ?CurlResponse $response = null;

    /**
     * @var OpenAIClient
     */
    protected OpenAIClient $client;

    /**
     * @var string
     */
    protected string $contentTypeValidator = ApplicationJsonValidator::class;

    /**
     * @param CurlRequest $request
     *
     * @return void
     */
    public function setRequest(CurlRequest $request): void
    {
        $this->request = $request;
        $this->response = null;
        $this->contentTypeValidator = ApplicationJsonValidator::class;
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
     * Get the value of contentTypeValidator
     *
     * @return  string
     */
    public function getContentTypeValidator()
    {
        return $this->contentTypeValidator;
    }

    /**
     * @param CurlResponse $response
     *
     * @return self
     */
    protected function checkResponse(CurlResponse $response): self
    {

        if (!(new StatusValidator($response))->validate()) {
            throw new ApiException($this->formatError($response));
        }

        if (!(new $this->contentTypeValidator($response))->validate()) {
            throw new ApiException(\sprintf('Unsupported content type: %s', $response->getHeaderLine('Content-Type')));
        }

        return $this;
    }

    protected function decodeResponse(CurlResponse $response, bool $asArray = false): array|\stdClass
    {
        $body =  json_decode($response, $asArray);

        if (\json_last_error()) {
            throw new ApiException(
                'Failed to parse JSON response body: ' . \json_last_error_msg()
            );
        }

        return $body;
    }

    protected function formatError(CurlResponse $response): string
    {
        $body = json_decode($response);

        if (\json_last_error()) {
            return \sprintf(
                'status: %s\nmessage: %s\ntype: %s\param: %s\ncode: %s\n',
                $response->getStatusCode(),
                $response->getBody(),
                '',
                '',
                '',
            );
        }

        return \sprintf(
            'status: %s\nmessage: %s\ntype: %s\param: %s\ncode: %s\n',
            $response->getStatusCode(),
            $body->error->message,
            $body->error->type,
            $body->error->param,
            $body->error->code,
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $response = $this->getResponse();
        return $this->checkResponse($response)->decodeResponse($response, true);
    }

    /**
     * @return \stdClass
     */
    public function toObject(): \stdClass
    {
        $response = $this->getResponse();
        return $this->checkResponse($response)->decodeResponse($response);
    }
}
