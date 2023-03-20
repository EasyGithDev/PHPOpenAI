<?php

namespace EasyGithDev\PHPOpenAI\Curl\Responses;

use EasyGithDev\PHPOpenAI\Curl\CurlResponse;
use stdClass;

class EmbeddingResponse extends CurlResponse
{

    function datas(): array
    {
        return $this->toObject()->data;
    }

    function data(int $n): stdClass
    {
        return $this->toObject()->data[$n];
    }
}
