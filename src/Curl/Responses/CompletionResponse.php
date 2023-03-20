<?php

namespace EasyGithDev\PHPOpenAI\Curl\Responses;

use EasyGithDev\PHPOpenAI\Curl\CurlResponse;
use stdClass;

class CompletionResponse extends CurlResponse
{

    function choices(): array
    {
        return $this->toObject()->choices;
    }

    function choice(int $n): stdClass
    {
        return $this->toObject()->choices[$n];
    }

    function fetchAll(): array
    {
        return array_map(function ($value) {
            return $value->text;
        }, $this->toObject()->choices);
    }
}
