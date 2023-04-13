<?php

namespace EasyGithDev\PHPOpenAI;

use EasyGithDev\PHPOpenAI\Contracts\RouteInterface;
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
use EasyGithDev\PHPOpenAI\Exceptions\ClientException;
use EasyGithDev\PHPOpenAI\Handlers\Embedding;
use EasyGithDev\PHPOpenAI\Handlers\FineTune;

/**
 * [Description OpenAIClient]
 */
class OpenAIClient
{
    /**
     * @var OpenAIConfiguration
     */
    protected OpenAIConfiguration $configuration;

    /**
     * Build a HTTP client
     * @param OpenAIConfiguration|string $var
     */
    public function __construct(OpenAIConfiguration|string $var, protected ?RouteInterface $route = null)
    {
        if (is_string($var) && empty($var)) {
            throw new ClientException("The API key can not be empty");
        }

        if (is_a($var, OpenAIConfiguration::class) && is_null($var)) {
            throw new ClientException("The configuration can not be null");
        }

        $this->configuration = (is_string($var)) ? OpenAIConfiguration::Configuration($var) : $var;

        if (is_null($route)) {
            $this->route = new OpenAIRoute();
        }
    }

    /**
     * Retrieve a Model handler
     * @return Model
     */
    public function Model(): Model
    {
        return new Model($this);
    }

    /**
     * Retrieve a Completion handler
     *
     * @return Completion
     */
    public function Completion(): Completion
    {
        return new Completion($this);
    }

    /**
     * Retrieve an Edit handler
     *
     * @return Edit
     */
    public function Edit(): Edit
    {
        return new Edit($this);
    }

    /**
     * Retrieve a Chat handler
     *
     * @return Chat
     */
    public function Chat(): Chat
    {
        return new Chat($this);
    }

    /**
     * Retrieve an Image handler
     *
     * @return Image
     */
    public function Image(): Image
    {
        return new Image($this);
    }

    /**
     * Retrieve an Audio handler
     *
     * @return Audio
     */
    public function Audio(): Audio
    {
        return new Audio($this);
    }

    /**
     * Retrieve a Moderation handler
     *
     * @return Moderation
     */
    public function Moderation(): Moderation
    {
        return new Moderation($this);
    }

    /**
     * Retrieve a File handler
     *
     * @return File
     */
    public function File(): File
    {
        return new File($this);
    }

    /**
     * Retrieve a FineTune handler
     *
     * @return FineTune
     */
    public function FineTune(): FineTune
    {
        return new Finetune($this);
    }

    /**
     * Retrieve an Embedding handler
     *
     * @return Embedding
     */
    public function Embedding(): Embedding
    {
        return new Embedding($this);
    }

    /**
     * Get the value of configuration
     * @return OpenAIConfiguration
     */
    public function getConfiguration(): OpenAIConfiguration
    {
        return $this->configuration;
    }

    /**
     * Get routes
     */
    public function getRoute(): RouteInterface
    {
        return $this->route;
    }

    /**
     * Set routes
     *
     * @return  self
     */
    public function setRoute(RouteInterface $route): self
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Build a GET HTTP request
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
            ->setUrl($path)
            ->setMethod(CurlRequest::CURL_GET)
            ->setHeaders([...$this->getConfiguration()->getHeaders(),...$headers]);

        if (isset($params['stream']) && $params['stream']) {
            $request->setCallback($params['callback']);
        }

        return $request;
    }

    /**
     * Build a POST HTTP request
     *
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
            ->setUrl($path)
            ->setMethod(CurlRequest::CURL_POST)
            ->setPayload($body)
            ->setHeaders([...$this->getConfiguration()->getHeaders(),...$headers]);

        if (isset($params['stream']) && $params['stream']) {
            $request->setCallback($params['callback']);
        }

        if (isset($params['timeout']) && $params['timeout']) {
            $request->setTimeout($params['timeout']);
        }

        return $request;
    }

    /**
     * Build a PUT HTTP request
     *
     * @param string $path
     * @param null $body
     * @param array $headers
     * @param array $params
     *
     * @return CurlRequest
     */
    public function put(string $path, $body = null, array $headers = [], array $params = []): CurlRequest
    {
        return (new CurlRequest())
            ->setUrl($path)
            ->setMethod(CurlRequest::CURL_PUT)
            ->setPayload($body)
            ->setHeaders([...$this->getConfiguration()->getHeaders(),...$headers]);
    }


    /**
     * Build a DELETE HTTP request
     *
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
            ->setUrl($path)
            ->setMethod(CurlRequest::CURL_DELETE)
            ->setPayload($body)
            ->setHeaders([...$this->getConfiguration()->getHeaders(),...$headers]);
    }

    /**
     * Perform an HTTP request
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
