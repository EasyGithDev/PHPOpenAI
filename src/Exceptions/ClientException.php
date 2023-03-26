<?php

namespace EasyGithDev\PHPOpenAI\Exceptions;

class ClientException extends \Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
