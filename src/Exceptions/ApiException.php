<?php

namespace EasyGithDev\PHPOpenAI\Exceptions;

class ApiException extends \Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
