<?php

namespace EasyGithDev\PHPOpenAI\Validators;

use EasyGithDev\PHPOpenAI\Contracts\ValidatorInterface;
use EasyGithDev\PHPOpenAI\Curl\CurlResponse;
use EasyGithDev\PHPOpenAI\Helpers\ContentTypeEnum;

class ApplicationOctetStreamValidator implements ValidatorInterface
{
    public function __construct(protected CurlResponse $response)
    {
    }

    public function validate(): bool
    {
        $contentType = mb_strtolower($this->response->getHeaderLine('Content-Type'));
        if (substr($contentType, 0, 24) !== ContentTypeEnum::OCTET->value && mb_strlen($contentType) !== 0) {
            return false;
        }
        return true;
    }
}
