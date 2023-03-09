<?php

namespace EasyGithDev\PHPOpenAI;

use EasyGithDev\PHPOpenAI\Chat\ChatCompletion;
use EasyGithDev\PHPOpenAI\Completions\Completion;
use EasyGithDev\PHPOpenAI\Images\Image;
use EasyGithDev\PHPOpenAI\Models\Model;
use EasyGithDev\PHPOpenAI\Speech2text\Audio;

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

    public function ChatCompletion(): ChatCompletion
    {
        $this->configuration->setApplicationJson();
        return new ChatCompletion(self::API_URL, $this->configuration->toArray());
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
}
