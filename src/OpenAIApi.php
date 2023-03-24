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
}
