<?php

namespace EasyGithDev\PHPOpenAI\Curl\Responses;

use EasyGithDev\PHPOpenAI\Curl\CurlResponse;

class AudioResponse extends CurlResponse
{
    public function text(): string
    {
        return $this->getBuffer();
    }
}
