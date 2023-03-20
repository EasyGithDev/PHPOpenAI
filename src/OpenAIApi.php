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
use EasyGithDev\PHPOpenAI\Curl\Responses\AudioResponse;
use EasyGithDev\PHPOpenAI\Curl\Responses\ChatResponse;
use EasyGithDev\PHPOpenAI\Curl\Responses\CompletionResponse;
use EasyGithDev\PHPOpenAI\Curl\Responses\EditResponse;
use EasyGithDev\PHPOpenAI\Curl\Responses\EmbeddingResponse;
use EasyGithDev\PHPOpenAI\Curl\Responses\FileResponse;
use EasyGithDev\PHPOpenAI\Curl\Responses\ImageResponse;
use EasyGithDev\PHPOpenAI\Curl\Responses\ModelResponse;
use EasyGithDev\PHPOpenAI\Curl\Responses\ModerationResponse;
use EasyGithDev\PHPOpenAI\Curl\Responses\FineTuneResponse;
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
        return new Model((new CurlRequest())
                ->setHeaders($this->configuration->getCurlHeaders())
                ->setBaseUrl($this->configuration->getApiUrl()),
            new ModelResponse()
        );
    }

    public function Completion(): Completion
    {
        return new Completion((new CurlRequest())
                ->setHeaders($this->configuration->getCurlHeaders())
                ->setBaseUrl($this->configuration->getApiUrl()),
            new CompletionResponse()
        );
    }

    public function Edit(): Edit
    {
        return new Edit(
            (new CurlRequest())
                ->setHeaders($this->configuration->getCurlHeaders())
                ->setBaseUrl($this->configuration->getApiUrl()),
            new EditResponse()
        );
    }

    public function Chat(): Chat
    {

        return new Chat(
            (new CurlRequest())
                ->setHeaders($this->configuration->getCurlHeaders())
                ->setBaseUrl($this->configuration->getApiUrl()),
            new ChatResponse()
        );
    }

    public function Image(): Image
    {
        return new Image(
            (new CurlRequest())
                ->setHeaders($this->configuration->getCurlHeaders())
                ->setBaseUrl($this->configuration->getApiUrl())
                ->setTimeout(30),
            new ImageResponse()
        );
    }

    public function Audio(): Audio
    {

        return new Audio(
            (new CurlRequest())
                ->setHeaders($this->configuration->getCurlHeaders())
                ->setBaseUrl($this->configuration->getApiUrl()),
            new AudioResponse()
        );
    }

    public function Moderation(): Moderation
    {

        return new Moderation(
            (new CurlRequest())
                ->setHeaders($this->configuration->getCurlHeaders())
                ->setBaseUrl($this->configuration->getApiUrl()),
            new ModerationResponse()
        );
    }

    public function File(): File
    {
        return new File(
            (new CurlRequest())
                ->setHeaders($this->configuration->getCurlHeaders())
                ->setBaseUrl($this->configuration->getApiUrl()),
            new FileResponse()
        );
    }

    public function FineTune(): FineTune
    {
        return new Finetune(
            (new CurlRequest())
                ->setHeaders($this->configuration->getCurlHeaders())
                ->setBaseUrl($this->configuration->getApiUrl()),
            new CurlResponse()
        );
    }

    public function Embedding(): Embedding
    {
        return new Embedding(
            (new CurlRequest())
                ->setHeaders($this->configuration->getCurlHeaders())
                ->setBaseUrl($this->configuration->getApiUrl()),
            new EmbeddingResponse()
        );
    }
}
