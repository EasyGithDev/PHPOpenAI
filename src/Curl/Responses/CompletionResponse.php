<?php

namespace EasyGithDev\PHPOpenAI\Curl\Response;

use EasyGithDev\PHPOpenAI\Curl\CurlResponse;

class CompletionResponse extends CurlResponse
{

    function choices()
    {
        return $this->toObject()->choices;
    }

    function first()
    {
        return $this->toObject()->choices;
    }
}
