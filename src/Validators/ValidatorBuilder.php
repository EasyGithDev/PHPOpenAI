<?php

namespace EasyGithDev\PHPOpenAI\Validators;

use EasyGithDev\PHPOpenAI\Contracts\ValidatorInterface;
use EasyGithDev\PHPOpenAI\Curl\CurlResponse;

class ValidatorBuilder
{
    public static function create(string $name, CurlResponse $response): ValidatorInterface
    {
        $name = str_replace(__NAMESPACE__, '', $name);
        $name = trim($name, '\\');
        $name = rtrim($name, 'Validator');
        $name = ucfirst($name);
        $className = __NAMESPACE__ . '\\' . $name . 'Validator';

        return new  $className($response);
    }
}
