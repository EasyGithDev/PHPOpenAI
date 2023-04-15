<?php

namespace EasyGithDev\PHPOpenAI;

use EasyGithDev\PHPOpenAI\Contracts\HandlerInterface;
use EasyGithDev\PHPOpenAI\Curl\CurlOutput;
use EasyGithDev\PHPOpenAI\Curl\CurlRequest;
use EasyGithDev\PHPOpenAI\Curl\CurlResponse;
use EasyGithDev\PHPOpenAI\Exceptions\ClientException;
use EasyGithDev\PHPOpenAI\Validators\ApplicationJsonValidator;

/**
 * This abstract class defines methods for handling HTTP requests and responses to the OpenAI API.
 *
 * Here are the key features of this class:
 *
 * It has a property named $request which represents
 * the HTTP request to be sent to the API.
 *
 * It has a property named $response which represents
 * the HTTP response returned by the API.
 *
 * It has a property named $client of type OpenAIClient,
 * which is used to send the HTTP request and receive the response.
 *
 * It has a property named $contentTypeValidator which is used
 * to validate the content type of the response received from the API.
 *
 * It has a property named $curlParams which contains
 * additional parameters to be included in the HTTP request.
 */
abstract class OpenAIHandler implements HandlerInterface
{
    /**
     * The HTTP request
     * @var CurlRequest|null|null
     */
    protected ?CurlRequest $request = null;

    /**
     * The HTTP response
     * @var CurlResponse|null|null
     */
    protected ?CurlResponse $response = null;

    /**
     * The client
     * @var OpenAIClient
     */
    protected OpenAIClient $client;

    /**
     * The validator of content-type response
     * @var string
     */
    protected string $contentTypeValidator = ApplicationJsonValidator::class;

    /**
     * Additionnal parameters for curl request
     * @var array
     */
    protected array $curlParams = [];

    /**
     * Set the request to the handler
     * @param CurlRequest $request
     *
     * @return void
     */
    public function setRequest(CurlRequest $request): void
    {
        $this->request = $request;
        $this->response = null;
        $this->contentTypeValidator = ApplicationJsonValidator::class;
        $this->curlParams = [];
    }

    /**
     * Get the request from the handler
     *
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
     * Get the response from the handler
     * If the response exist, it will be returned
     * else the client will send the request and return
     * the response
     *
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
     * Add an additionnal parameter for curl request
     * @param string $key
     * @param mixed $value
     *
     * @return self
     */
    public function addCurlParam(string $key, mixed $value): self
    {
        if (!\is_null($this->request)) {
            throw new ClientException('Params must be configured before request.');
        }

        $this->curlParams[$key] = $value;

        return $this;
    }

    /**
     * Get an array response from the handler
     * @return array
     */
    public function toArray(): array
    {
        return (new CurlOutput($this->getResponse()))
            ->checkStatus()
            ->checkContentType($this->getContentTypeValidator())
            ->decodeResponse(true);
    }

    /**
     * Get an object response from the handler
     *
     * @return \stdClass
     */
    public function toObject(): \stdClass
    {
        return (new CurlOutput($this->getResponse()))
            ->checkStatus()
            ->checkContentType($this->getContentTypeValidator())
            ->decodeResponse();
    }
}
