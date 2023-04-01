<?php

namespace EasyGithDev\PHPOpenAI\Helpers;

/**
 * [Description ChatMessage]
 */
class ChatMessage
{
    public const ROLE_USER = 'user';
    public const ROLE_SYSTEM = 'system';
    public const ROLE_ASSISTANT = 'assistant';

    /**
     * @param  protected
     * @param  protected
     */
    public function __construct(protected string $role, protected string $content)
    {
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
