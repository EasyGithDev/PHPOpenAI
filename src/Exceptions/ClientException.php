<?php

namespace EasyGithDev\PHPOpenAI\Exceptions;

/**
 * [Description ClientException]
 */
class ClientException extends \Exception
{
    /**
     * @param string $message
     */
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
