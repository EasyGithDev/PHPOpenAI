<?php

namespace EasyGithDev\PHPOpenAI\Exceptions;

/**
 * [Description ApiException]
 */
class ApiException extends \Exception
{
    /**
     * @param string $message
     */
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
