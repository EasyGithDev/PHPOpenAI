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
        return new Model(
            $this->configuration->getApiUrl(),
            $this->configuration->getCurlHeaders([['Content-Type' => 'application/json']])
        );
    }

    public function Completion(): Completion
    {
        return new Completion(
            $this->configuration->getApiUrl(),
            $this->configuration->getCurlHeaders([['Content-Type' => 'application/json']])
        );
    }

    public function Edit(): Edit
    {
        return new Edit(
            $this->configuration->getApiUrl(),
            $this->configuration->getCurlHeaders([['Content-Type' => 'application/json']])
        );
    }

    public function Chat(): Chat
    {
        return new Chat(
            $this->configuration->getApiUrl(),
            $this->configuration->getCurlHeaders([['Content-Type' => 'application/json']])
        );
    }

    public function Image(): Image
    {
        return new Image(
            $this->configuration->getApiUrl(),
            $this->configuration->getCurlHeaders()
        );
    }

    public function ImageVariation(): Image
    {
        return new Image(
            $this->configuration->getApiUrl(),
            $this->configuration->getCurlHeaders()
        );
    }

    public function ImageEdit(): Image
    {
        return new Image(
            $this->configuration->getApiUrl(),
            $this->configuration->getCurlHeaders()
        );
    }

    public function Audio(): Audio
    {
        return new Audio(
            $this->configuration->getApiUrl(),
            $this->configuration->getCurlHeaders()
        );
    }

    public function Moderation(): Moderation
    {
        return new Moderation(
            $this->configuration->getApiUrl(),
            $this->configuration->getCurlHeaders([['Content-Type' => 'application/json']])
        );
    }

    public function File(): File
    {
        return new File(
            $this->configuration->getApiUrl(),
            $this->configuration->getCurlHeaders()
        );
    }

    public function Embedding(): Embedding
    {
        return new Embedding(
            $this->configuration->getApiUrl(),
            $this->configuration->getCurlHeaders([['Content-Type' => 'application/json']])
        );
    }
}
