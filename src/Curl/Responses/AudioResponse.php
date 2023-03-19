<?php

namespace EasyGithDev\PHPOpenAI\Curl\Responses;

use EasyGithDev\PHPOpenAI\Curl\CurlResponse;

class AudioResponse extends CurlResponse
{

    function text(): string
    {
        return $this->toObject()->text;
    }
}
