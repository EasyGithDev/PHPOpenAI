<?php

namespace EasyGithDev\PHPOpenAI\Curl\Responses;

use EasyGithDev\PHPOpenAI\Curl\CurlResponse;
use stdClass;

class ModelResponse extends CurlResponse
{
    public function datas(): array
    {
        return $this->toObject()->data;
    }

    public function data(int $n): stdClass
    {
        return $this->toObject()->data[$n];
    }

    public function fetchAll(): array
    {
        return array_map(function ($value) {
            return $value->id;
        }, $this->toObject()->data);
    }
}
