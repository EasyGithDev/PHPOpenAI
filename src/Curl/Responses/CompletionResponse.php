<?php

namespace EasyGithDev\PHPOpenAI\Curl\Responses;

use EasyGithDev\PHPOpenAI\Curl\CurlResponse;

class CompletionResponse extends CurlResponse
{

    function choices() : array
    {
        return $this->toObject()->choices;
    }

    function first() : string
    {
        return $this->toObject()->choices[0]->text;
    }
}
