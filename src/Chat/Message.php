<?php

namespace EasyGithDev\PHPOpenAI\Chat;

class Message
{
    const ROLE_USER = 'user';
    const ROLE_SYSTEM = 'system';
    const ROLE_ASSISTANT = 'assistant';

    function __construct(protected string $role, protected string $content)
    {
    }

    function toArray(): array
    {
        return get_object_vars($this);
    }
}
