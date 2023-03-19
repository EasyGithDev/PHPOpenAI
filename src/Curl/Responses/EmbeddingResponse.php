<?php

namespace EasyGithDev\PHPOpenAI\Curl\Responses;

use EasyGithDev\PHPOpenAI\Curl\CurlResponse;

class EmbeddingResponse extends CurlResponse
{

    function choices()
    {
        return $this->toObject()->data;
    }

    function first()
    {
        return $this->toObject()->data[0];
    }
}
