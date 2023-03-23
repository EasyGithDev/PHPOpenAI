<?php

namespace EasyGithDev\PHPOpenAI\Chats;

class Message
{
    public const ROLE_USER = 'user';
    public const ROLE_SYSTEM = 'system';
    public const ROLE_ASSISTANT = 'assistant';

    public function __construct(protected string $role, protected string $content)
    {
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
