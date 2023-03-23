<?php

namespace EasyGithDev\PHPOpenAI\Exceptions;

use stdClass;

class ApiException extends \Exception
{
    public function __construct(int $httpCode, stdClass $obj)
    {
        $message = 'Api error : ' . $httpCode . PHP_EOL .
            "message:" . $obj->message . PHP_EOL .
            "type:" . $obj->type . PHP_EOL .
            "param:" . $obj->param . PHP_EOL .
            "code:" . $obj->code;
        parent::__construct($message, $httpCode);
    }
}
