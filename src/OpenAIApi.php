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
    const API_URL = 'https://api.openai.com/v1';

    public function __construct(protected Configuration $configuration)
    {
    }

    public function Model(): Model
    {
        $this->configuration->setApplicationJson();
        return new Model(self::API_URL, $this->configuration->toArray());
    }

    public function Completion(): Completion
    {
        $this->configuration->setApplicationJson();
        return new Completion(self::API_URL, $this->configuration->toArray());
    }

    public function Edit(): Edit
    {
        $this->configuration->setApplicationJson();
        return new Edit(self::API_URL, $this->configuration->toArray());
    }

    public function Chat(): Chat
    {
        $this->configuration->setApplicationJson();
        return new Chat(self::API_URL, $this->configuration->toArray());
    }

    public function Image(): Image
    {
        $this->configuration->setApplicationJson();
        return new Image(self::API_URL, $this->configuration->toArray());
    }

    public function ImageVariation(): Image
    {
        return new Image(self::API_URL, $this->configuration->toArray());
    }

    public function ImageEdit(): Image
    {
        return new Image(self::API_URL, $this->configuration->toArray());
    }

    public function Transcription(): Audio
    {
        return new Audio(self::API_URL, $this->configuration->toArray());
    }

    public function Moderation(): Moderation
    {
        $this->configuration->setApplicationJson();
        return new Moderation(self::API_URL, $this->configuration->toArray());
    }

    public function File(bool $useJson = true): File
    {
        if ($useJson) {
            $this->configuration->setApplicationJson();
        }
        return new File(self::API_URL, $this->configuration->toArray());
    }
}
