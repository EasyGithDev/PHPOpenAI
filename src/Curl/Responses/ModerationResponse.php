<?php

namespace EasyGithDev\PHPOpenAI\Curl\Responses;

use EasyGithDev\PHPOpenAI\Curl\CurlResponse;
use stdClass;

class ModerationResponse extends CurlResponse
{
    public function results(): array
    {
        return $this->toObject()->results;
    }

    public function result(int $n): stdClass
    {
        return $this->toObject()->results[$n];
    }

    public function categories(): stdClass
    {
        return $this->result(0)->categories;
    }

    public function scores(): stdClass
    {
        return $this->result(0)->category_scores;
    }
}
