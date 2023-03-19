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
use EasyGithDev\PHPOpenAI\Curl\Responses\AudioResponse;
use EasyGithDev\PHPOpenAI\Curl\Responses\ChatResponse;
use EasyGithDev\PHPOpenAI\Curl\Responses\CompletionResponse;
use EasyGithDev\PHPOpenAI\Curl\Responses\EditResponse;
use EasyGithDev\PHPOpenAI\Curl\Responses\EmbedingResponse;
use EasyGithDev\PHPOpenAI\Curl\Responses\FileResponse;
use EasyGithDev\PHPOpenAI\Curl\Responses\ImageResponse;
use EasyGithDev\PHPOpenAI\Curl\Responses\ModelResponse;
use EasyGithDev\PHPOpenAI\Curl\Responses\ModerationResponse;
use EasyGithDev\PHPOpenAI\Embeddings\Embedding;

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
        $curl = (new CurlRequest())
            ->setHeaders(
                $this->configuration->getCurlHeaders([['Content-Type' => 'application/json']])
            )
            ->setBaseUrl(
                $this->configuration->getApiUrl()
            );
        return new Model($curl, new ModelResponse());
    }

    public function Completion(): Completion
    {
        $curl = (new CurlRequest())
            ->setHeaders(
                $this->configuration->getCurlHeaders([['Content-Type' => 'application/json']])
            )
            ->setBaseUrl(
                $this->configuration->getApiUrl()
            );
        return new Completion($curl, new CompletionResponse());
    }

    public function Edit(): Edit
    {
        $curl = (new CurlRequest())
            ->setHeaders(
                $this->configuration->getCurlHeaders([['Content-Type' => 'application/json']])
            )
            ->setBaseUrl(
                $this->configuration->getApiUrl()
            );
        return new Edit(
            $curl, new EditResponse()
        );
    }

    public function Chat(): Chat
    {
        $curl = (new CurlRequest())
            ->setHeaders(
                $this->configuration->getCurlHeaders([['Content-Type' => 'application/json']])
            )
            ->setBaseUrl(
                $this->configuration->getApiUrl()
            );
        return new Chat(
            $curl, new ChatResponse()
        );
    }

    public function Image(): Image
    {
        $curl = (new CurlRequest())
            ->setHeaders(
                $this->configuration->getCurlHeaders([['Content-Type' => 'application/json']])
            )
            ->setBaseUrl(
                $this->configuration->getApiUrl()
            );
        return new Image(
            $curl, new ImageResponse()
        );
    }

    public function ImageVariation(): Image
    {
        $curl = (new CurlRequest())
            ->setHeaders(
                $this->configuration->getCurlHeaders()
            )
            ->setBaseUrl(
                $this->configuration->getApiUrl()
            )
            ->setTimeout(20);
        return new Image(
            $curl, new ImageResponse()

        );
    }

    public function ImageEdit(): Image
    {
        $curl = (new CurlRequest())
            ->setHeaders(
                $this->configuration->getCurlHeaders()
            )
            ->setBaseUrl(
                $this->configuration->getApiUrl()
            )
            ->setTimeout(20);
        return new Image(
            $curl, new ImageResponse()

        );
    }

    public function Audio(): Audio
    {
        $curl = (new CurlRequest())
            ->setHeaders(
                $this->configuration->getCurlHeaders()
            )
            ->setBaseUrl(
                $this->configuration->getApiUrl()
            );
        return new Audio(
            $curl, new AudioResponse()
        );
    }

    public function Moderation(): Moderation
    {
        $curl = (new CurlRequest())
            ->setHeaders(
                $this->configuration->getCurlHeaders([['Content-Type' => 'application/json']])
            )
            ->setBaseUrl(
                $this->configuration->getApiUrl()
            );
        return new Moderation(
            $curl, new ModerationResponse()
        );
    }

    public function File(): File
    {
        $curl = (new CurlRequest())
            ->setHeaders(
                $this->configuration->getCurlHeaders()
            )
            ->setBaseUrl(
                $this->configuration->getApiUrl()
            );
        return new File(
            $curl, new FileResponse()
        );
    }

    public function Embedding(): Embedding
    {
        $curl = (new CurlRequest())
            ->setHeaders(
                $this->configuration->getCurlHeaders([['Content-Type' => 'application/json']])
            )
            ->setBaseUrl(
                $this->configuration->getApiUrl()
            );
        return new Embedding($curl, new EmbedingResponse());
    }
}
