<?php

namespace EasyGithDev\PHPOpenAI;

use EasyGithDev\PHPOpenAI\Contracts\HeaderInterface;
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
 * This class is responsible for managing the URL
 * and accessing the different entry points of the API.
 *
 * It has a constructor that takes an object or a string to manage the API key,
 * and an optional RouteInterface object to manage the entries.
 *
 * The class also has several methods that retrieve different handlers for interacting with the API,
 * including Model(), Completion(), Edit(), Chat(), Image(), Audio(), Moderation(), File(), FineTune(), and Embedding().
 * Each of these methods returns a different type of handler object for performing specific tasks with the API.
 *
 * The sendRequest() method is used to perform an HTTP request,
 * taking a CurlRequest object as a parameter, and returning a CurlResponse object.
 */
class OpenAIClient
{
    /**
     * @var HeaderInterface
     */
    protected HeaderInterface $configuration;

    /**
     * Build a HTTP client
     * @param HeaderInterface|string $var
     */
    public function __construct(HeaderInterface|string $var, protected ?RouteInterface $route = null)
    {
        if (is_string($var) && empty($var)) {
            throw new ClientException("The API key can not be empty");
        }

        if (is_a($var, HeaderInterface::class) && is_null($var)) {
            throw new ClientException("The configuration can not be null");
        }

        $this->configuration = (is_string($var)) ? static::createConfiguration($var) : $var;

        if (is_null($route)) {
            $this->route = new OpenAIRoute();
        }
    }

    /**
     * Build the configuration headers needed by the api
     * 
     * @param string $apiKey
     * @param string $organization
     * 
     * @return self
     */
    public static function createConfiguration(string $apiKey, string $organization = ''): HeaderInterface
    {
        return new OpenAIConfiguration($apiKey, $organization);
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
     * @return HeaderInterface
     */
    public function getConfiguration(): HeaderInterface
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
