<?php

namespace EasyGithDev\PHPOpenAI;

use stdClass;

class Response
{

    private string $buffer;
    private int $httpCode;

    public function __construct(string $buffer, int $httpCode)
    {
        $this->buffer = $buffer;
        $this->httpCode = $httpCode;
    }

    /**
     * Get the value of httpCode
     */
    public function getHttpCode(): int
    {
        return $this->httpCode;
    }

    /**
     * Get the value of buffer
     */
    public function getBuffer(): string
    {
        return $this->buffer;
    }

    public function __toString(): string
    {
        return $this->buffer;
    }

    public function toArray(): array
    {
        return json_decode($this->buffer, true);
    }

    public function toObject(): stdClass
    {
        return json_decode($this->buffer);
    }
}
