<?php

namespace EasyGithDev\PHPOpenAI;

use EasyGithDev\PHPOpenAI\Handlers\Completion;
use EasyGithDev\PHPOpenAI\Handlers\Edit;
use EasyGithDev\PHPOpenAI\Handlers\File;
use EasyGithDev\PHPOpenAI\Handlers\Image;
use EasyGithDev\PHPOpenAI\Handlers\Model;
use EasyGithDev\PHPOpenAI\Handlers\Moderation;
use EasyGithDev\PHPOpenAI\Handlers\Audio;
use EasyGithDev\PHPOpenAI\Handlers\Chat;
use EasyGithDev\PHPOpenAI\Curl\CurlRequest;
use EasyGithDev\PHPOpenAI\Curl\CurlResponse;
use EasyGithDev\PHPOpenAI\Handlers\Embedding;
use EasyGithDev\PHPOpenAI\Handlers\FineTune;

/**
 * [Description OpenAIClient]
 */
class OpenAIClient
{
    protected ?OpenAIConfiguration $configuration = null;

    /**
     * @param OpenAIConfiguration|string $var
     */
    public function __construct(OpenAIConfiguration|string $var)
    {
        $this->configuration = (is_string($var)) ? OpenAIConfiguration::Configuration($var) : $var;
    }

    /**
     * @return Model
     */
    public function Model(): Model
    {
        return new Model($this);
    }

    /**
     * @return Completion
     */
    public function Completion(): Completion
    {
        return new Completion($this);
    }

    /**
     * @return Edit
     */
    public function Edit(): Edit
    {
        return new Edit($this);
    }

    /**
     * @return Chat
     */
    public function Chat(): Chat
    {
        return new Chat($this);
    }

    /**
     * @return Image
     */
    public function Image(): Image
    {
        return new Image($this);
    }

    /**
     * @return Audio
     */
    public function Audio(): Audio
    {
        return new Audio($this);
    }

    /**
     * @return Moderation
     */
    public function Moderation(): Moderation
    {
        return new Moderation($this);
    }

    /**
     * @return File
     */
    public function File(): File
    {
        return new File($this);
    }

    /**
     * @return FineTune
     */
    public function FineTune(): FineTune
    {
        return new Finetune($this);
    }

    /**
     * @return Embedding
     */
    public function Embedding(): Embedding
    {
        return new Embedding($this);
    }

    /**
     * Get the value of configuration
     */
    public function getConfiguration(): OpenAIConfiguration
    {
        return $this->configuration;
    }

    /**
     * @param string $path
     * @param null $body
     * @param array $headers
     * @param array $params
     *
     * @return CurlRequest
     */
    public function get(string $path, $body = null, array $headers = [], array $params = []): CurlRequest
    {
        $request = (new CurlRequest())
            ->setBaseHeaders($this->getConfiguration()->getHeaders())
            ->setBaseUrl($this->getConfiguration()->getApiUrl())
            ->setUrl($path)
            ->setMethod(CurlRequest::CURL_GET)
            ->setHeaders($headers);

        if (isset($params['stream']) && $params['stream']) {
            $request->setCallback($params['callback']);
        }

        return $request;
    }

    /**
     * @param string $path
     * @param null $body
     * @param array $headers
     * @param array $params
     *
     * @return CurlRequest
     */
    public function post(string $path, $body = null, array $headers = [], array $params = []): CurlRequest
    {
        $request = (new CurlRequest())
            ->setBaseHeaders($this->getConfiguration()->getHeaders())
            ->setBaseUrl($this->getConfiguration()->getApiUrl())
            ->setUrl($path)
            ->setMethod(CurlRequest::CURL_POST)
            ->setPayload($body)
            ->setHeaders($headers);

        if (isset($params['stream']) && $params['stream']) {
            $request->setCallback($params['callback']);
        }

        if (isset($params['timeout']) && $params['timeout']) {
            $request->setTimeout($params['timeout']);
        }

        return $request;
    }

    /**
     * @param string $path
     * @param null $body
     * @param array $headers
     * @param array $params
     *
     * @return RequestInterface
     */
    public function put(string $path, $body = null, array $headers = [], array $params = []): CurlRequest
    {
        return (new CurlRequest())
            ->setBaseHeaders($this->getConfiguration()->getHeaders())
            ->setBaseUrl($this->getConfiguration()->getApiUrl())
            ->setUrl($path)
            ->setMethod(CurlRequest::CURL_PUT)
            ->setPayload($body)
            ->setHeaders($headers);
    }


    /**
     * @param string $path
     * @param null $body
     * @param array $headers
     * @param array $params
     *
     * @return CurlRequest
     */
    public function delete(string $path, $body = null, array $headers = [], array $params = []): CurlRequest
    {
        return (new CurlRequest())
            ->setBaseHeaders($this->getConfiguration()->getHeaders())
            ->setBaseUrl($this->getConfiguration()->getApiUrl())
            ->setUrl($path)
            ->setMethod(CurlRequest::CURL_DELETE)
            ->setPayload($body)
            ->setHeaders($headers);
    }

    /**
     * @param CurlRequest $request
     *
     * @return CurlResponse
     */
    public function sendRequest(CurlRequest $request): CurlResponse
    {
        $response = $request->exec();
        $request->close();
        return new CurlResponse($response);
    }
}
