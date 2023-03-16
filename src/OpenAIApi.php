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
        $this->configuration->setApplicationJson();
        return new Model($this->configuration->getApiUrl(), $this->configuration->toArray());
    }

    public function Completion(): Completion
    {
        $this->configuration->setApplicationJson();
        return new Completion($this->configuration->getApiUrl(), $this->configuration->toArray());
    }

    public function Edit(): Edit
    {
        $this->configuration->setApplicationJson();
        return new Edit($this->configuration->getApiUrl(), $this->configuration->toArray());
    }

    public function Chat(): Chat
    {
        $this->configuration->setApplicationJson();
        return new Chat($this->configuration->getApiUrl(), $this->configuration->toArray());
    }

    public function Image(): Image
    {
        $this->configuration->setApplicationJson();
        return new Image($this->configuration->getApiUrl(), $this->configuration->toArray());
    }

    public function ImageVariation(): Image
    {
        return new Image($this->configuration->getApiUrl(), $this->configuration->toArray());
    }

    public function ImageEdit(): Image
    {
        return new Image($this->configuration->getApiUrl(), $this->configuration->toArray());
    }

    public function Audio(): Audio
    {
        return new Audio($this->configuration->getApiUrl(), $this->configuration->toArray());
    }

    public function Moderation(): Moderation
    {
        $this->configuration->setApplicationJson();
        return new Moderation($this->configuration->getApiUrl(), $this->configuration->toArray());
    }

    public function File(): File
    {
        return new File($this->configuration->getApiUrl(), $this->configuration->toArray());
    }
}
