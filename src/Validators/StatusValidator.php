<?php

namespace EasyGithDev\PHPOpenAI\Validators;

use EasyGithDev\PHPOpenAI\Contracts\ValidatorInterface;
use EasyGithDev\PHPOpenAI\Curl\CurlResponse;

class StatusValidator implements ValidatorInterface
{
    public function __construct(protected CurlResponse $response)
    {
    }

    public function validate(): bool
    {
        $status = $this->response->getStatusCode();
        return ($status >= 200 && $status <= 300);
    }
}
