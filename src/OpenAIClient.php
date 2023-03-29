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

class OpenAIClient
{
    protected ?OpenAIConfiguration $configuration = null;

    public function __construct(OpenAIConfiguration|string $var)
    {
        if (is_string($var)) {
            $this->configuration = OpenAIConfiguration::defaultConfiguration($var);
        } else {
            $this->configuration = $var;
        }
    }

    public function Model(): Model
    {
        return new Model($this);
    }

    public function Completion(): Completion
    {
        return new Completion($this);
    }

    public function Edit(): Edit
    {
        return new Edit($this);
    }

    public function Chat(): Chat
    {
        return new Chat($this);
    }

    public function Image(): Image
    {
        return new Image($this);
    }

    public function Audio(): Audio
    {
        return new Audio($this);
    }

    public function Moderation(): Moderation
    {
        return new Moderation($this);
    }

    public function File(): File
    {
        return new File($this);
    }

    public function FineTune(): FineTune
    {
        return new Finetune($this);
    }

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
