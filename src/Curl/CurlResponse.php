<?php

namespace EasyGithDev\PHPOpenAI\Curl;

/**
 * The CurlResponse class represents a HTTP response.
 * It implements the \JsonSerializable interface.
 */
class CurlResponse implements \JsonSerializable
{
    /**
     * @param  protected
     */
    public function __construct(protected array $infos)
    {
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->infos['curlinfo']['http_code'];
    }

    /**
     * @return string
     */
    public function getReasonPhrase(): string
    {
        return '';
    }

    /**
     * @return string
     */
    public function getHeaderLine(): string
    {
        return $this->infos['curlinfo']['content_type'];
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->infos['body'];
    }

    /**
     * Return output body as a string
     * @return string
     */
    public function __toString(): string
    {
        return $this->infos['body'];
    }

    /**
     * Get the value of infos
     */
    public function getInfos(): array
    {
        return $this->infos;
    }

    /**
     * Get the value of the curl log
     * @return string
     */
    public function getLog(): string
    {
        return $this->infos['curllog'];
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->infos;
    }
}
