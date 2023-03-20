<?php

namespace EasyGithDev\PHPOpenAI\Curl\Responses;

use EasyGithDev\PHPOpenAI\Curl\CurlResponse;
use stdClass;

class ModerationResponse extends CurlResponse
{

    function results(): array
    {
        return $this->toObject()->results;
    }

    function result(int $n): stdClass
    {
        return $this->toObject()->results[$n];
    }

    function categories(): stdClass
    {
        return $this->result(0)->categories;
    }

    function scores(): stdClass
    {
        return $this->result(0)->category_scores;
    }
}
