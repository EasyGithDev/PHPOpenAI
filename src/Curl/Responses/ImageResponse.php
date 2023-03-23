<?php

namespace EasyGithDev\PHPOpenAI\Curl\Responses;

use EasyGithDev\PHPOpenAI\Curl\CurlResponse;

class ImageResponse extends CurlResponse
{
    public function urlImages(): array
    {
        return array_map(function ($value) {
            return $value->url;
        }, $this->toObject()->data);
    }

    public function b64Images(): array
    {
        return array_map(function ($value) {
            return $value->b64_json;
        }, $this->toObject()->data);
    }
}
