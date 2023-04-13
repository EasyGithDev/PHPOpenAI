<?php

namespace EasyGithDev\PHPOpenAI;

use EasyGithDev\PHPOpenAI\Curl\CurlRequest;
use EasyGithDev\PHPOpenAI\Curl\CurlResponse;
use EasyGithDev\PHPOpenAI\Exceptions\ApiException;
use EasyGithDev\PHPOpenAI\Exceptions\ClientException;
use EasyGithDev\PHPOpenAI\Helpers\ContentTypeEnum;
use EasyGithDev\PHPOpenAI\Validators\ApplicationJsonValidator;
use EasyGithDev\PHPOpenAI\Validators\StatusValidator;

/**
 * [Description OpenAIHandler]
 */
abstract class OpenAIHandler
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
     * Check the status code ans the content type
     * of the response. It will throw an exception if
     * an error is occuring
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

    /**
     * Transform the body of the response into array
     * or object
     * @param CurlResponse $response
     * @param bool $asArray
     *
     * @return array|\stdClass
     */
    protected function decodeResponse(CurlResponse $response, bool $asArray = false): array|\stdClass
    {
        if (ContentTypeEnum::tryFrom($response->getHeaderLine()) != ContentTypeEnum::JSON) {
            if ($asArray) {
                return ['text' => $response->getBody()];
            } else {
                $obj = new \stdClass();
                $obj->text = $response->getBody();
                return $obj;
            }
        }

        $body =  json_decode($response, $asArray);

        if (\json_last_error()) {
            throw new ApiException(
                'Failed to parse JSON response body: ' . \json_last_error_msg()
            );
        }

        return $body;
    }

    /**
     * Format the response error into a trsing
     * @param CurlResponse $response
     *
     * @return string
     */
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
     * Get an array response from the handler
     * @return array
     */
    public function toArray(): array
    {
        $response = $this->getResponse();
        return $this->checkResponse($response)->decodeResponse($response, true);
    }

    /**
     * Get an object response from the handler
     *
     * @return \stdClass
     */
    public function toObject(): \stdClass
    {
        $response = $this->getResponse();
        return $this->checkResponse($response)->decodeResponse($response);
    }
}
