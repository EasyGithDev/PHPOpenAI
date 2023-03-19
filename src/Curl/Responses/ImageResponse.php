<?php

namespace EasyGithDev\PHPOpenAI\Curl\Responses;

use EasyGithDev\PHPOpenAI\Curl\CurlResponse;

class ImageResponse extends CurlResponse
{

    function choices()
    {
        return $this->toObject()->choices;
    }

    function first()
    {
        return $this->toObject()->choices[0];
    }
}
