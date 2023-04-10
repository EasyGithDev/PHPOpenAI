<?php

namespace EasyGithDev\PHPOpenAI\Validators;

use EasyGithDev\PHPOpenAI\Curl\CurlResponse;
use EasyGithDev\PHPOpenAI\Helpers\ContentTypeEnum;

class ApplicationJsonValidator implements Validator
{
    public function __construct(protected CurlResponse $response)
    {
    }

    public function validate(): bool
    {
        $contentType = mb_strtolower($this->response->getHeaderLine('Content-Type'));
        if (substr($contentType, 0, 16) !== ContentTypeEnum::JSON->value && mb_strlen($contentType) !== 0) {
            return false;
        }
        return true;
    }
}
