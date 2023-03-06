<?php

namespace EasyGithDev\PHPOpenAI;

use EasyGithDev\PHPOpenAI\Chat\ChatCompletion;
use EasyGithDev\PHPOpenAI\Completions\Completion;
use EasyGithDev\PHPOpenAI\Images\Image;
use EasyGithDev\PHPOpenAI\Models\Model;

class OpenAIApi
{
    const API_URL = 'https://api.openai.com/v1';

    public function __construct(protected Configuration $configuration)
    {
    }

    public function Model(): Model
    {
        return new Model(self::API_URL, $this->configuration->toArray());
    }

    public function Completion(): Completion
    {
        return new Completion(self::API_URL, $this->configuration->toArray());
    }

    public function ChatCompletion(): ChatCompletion
    {
        return new ChatCompletion(self::API_URL, $this->configuration->toArray());
    }

    public function Image(): Image
    {
        return new Image(self::API_URL, $this->configuration->toArray());
    }
}
