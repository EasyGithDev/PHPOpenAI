<?php

namespace EasyGithDev\PHPOpenAI\Validators;

use EasyGithDev\PHPOpenAI\Contracts\ValidatorInterface;
use EasyGithDev\PHPOpenAI\Curl\CurlResponse;


class ValidatorBuilder
{
    public static function create(string $name, CurlResponse $response): ValidatorInterface
    {
        $className = ucfirst($name) . 'Validator';
        return new $className($response);
    }
}
