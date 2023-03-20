<?php

namespace EasyGithDev\PHPOpenAI\Curl\Responses;

use EasyGithDev\PHPOpenAI\Curl\CurlResponse;
use stdClass;

class FileResponse extends CurlResponse
{

    function datas(): array
    {
        return $this->toObject()->data;
    }

    function data(int $n): stdClass
    {
        return $this->toObject()->data[$n];
    }

    function fetchAll(): array
    {
        return array_map(function ($value) {
            return $value->id;
        }, $this->datas());
    }
}
