<?php

namespace EasyGithDev\PHPOpenAI\Chat;

class Message
{
    function __construct(protected string $role, protected string $content)
    {
    }

    function toArray(): array
    {
        return get_object_vars($this);
    }
}
