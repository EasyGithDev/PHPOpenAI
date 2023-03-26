<?php

namespace EasyGithDev\PHPOpenAI;

use EasyGithDev\PHPOpenAI\Completions\Completion;
use EasyGithDev\PHPOpenAI\Edits\Edit;
use EasyGithDev\PHPOpenAI\Files\File;
use EasyGithDev\PHPOpenAI\Images\Image;
use EasyGithDev\PHPOpenAI\Models\Model;
use EasyGithDev\PHPOpenAI\Moderations\Moderation;
use EasyGithDev\PHPOpenAI\Audios\Audio;
use EasyGithDev\PHPOpenAI\Chats\Chat;
use EasyGithDev\PHPOpenAI\Curl\CurlRequest;
use EasyGithDev\PHPOpenAI\Curl\CurlResponse;
use EasyGithDev\PHPOpenAI\Embeddings\Embedding;
use EasyGithDev\PHPOpenAI\Finetunes\FineTune;

class OpenAIApi
{
    protected ?Configuration $configuration = null;

    public function __construct(Configuration|string $var)
    {
        if (is_string($var)) {
            $this->configuration = Configuration::defaultConfiguration($var);
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
    public function getConfiguration(): Configuration
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
        return (new CurlRequest())
            ->setBaseHeaders($this->getConfiguration()->getCurlHeaders())
            ->setBaseUrl($this->getConfiguration()->getApiUrl())
            ->setUrl($path)
            ->setMethod(CurlRequest::CURL_GET)
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
   public function post(string $path, $body = null, array $headers = [], array $params = []): CurlRequest
    {
        return (new CurlRequest())
            ->setBaseHeaders($this->getConfiguration()->getCurlHeaders())
            ->setBaseUrl($this->getConfiguration()->getApiUrl())
            ->setUrl($path)
            ->setMethod(CurlRequest::CURL_POST)
            ->setPayload($body)
            ->setHeaders($headers);
    }

   /**
    * @param string $path
    * @param null $body
    * @param array $headers
    * @param array $params
    * 
    * @return RequestInterface
    */
   public function put(string $path, $body = null, array $headers = [], array $params = []): RequestInterface
    {
        return (new CurlRequest())
            ->setBaseHeaders($this->getConfiguration()->getCurlHeaders())
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
            ->setBaseHeaders($this->getConfiguration()->getCurlHeaders())
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
    function sendRequest(CurlRequest $request): CurlResponse
    {
        $response = $request->exec();
        $request->close();
        return (new CurlResponse())->setInfos($response);
    }
}
