<?php

namespace EasyGithDev\PHPOpenAI\Curl;

use EasyGithDev\PHPOpenAI\Exceptions\ApiException;
use JsonSerializable;
use stdClass;

class CurlResponse implements JsonSerializable
{

    public function __construct(protected ?array $infos = null)
    {
    }

    /**
     * Get the value of httpCode
     */
    public function getHttpCode(): int
    {
        return $this->infos['output']['curlinfo']['http_code'];
    }

    /**
     * Get the input payload
     * @return string
     */
    public function getPayload(): string|array|null
    {
        return $this->infos['input']['payload'];
    }

    /**
     * Get the value of buffer
     */
    public function getBuffer(): string
    {
        return $this->infos['output']['buffer'];
    }

    /**
     * Return output buffer as a string
     * @return string
     */
    public function __toString(): string
    {
        return $this->infos['output']['buffer'];
    }

    /**
     * Return output buffer as an associative array
     * @return array
     */
    public function toArray(): array
    {
        return json_decode($this->infos['output']['buffer'], true);
    }

    /**
     * Return output buffer as an object
     * @return stdClass
     */
    public function toObject(): stdClass
    {
        return json_decode($this->infos['output']['buffer']);
    }

    /**
     * Get the value of infos
     */
    public function getInfos(): array
    {
        return $this->infos;
    }

    /**
     * Set the value of infos
     *
     * @return  self
     */
    public function setInfos($infos): self
    {
        $this->infos = $infos;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return $this->infos;
    }

    /**
     * @return bool
     */
    public function isOk(): bool
    {
        return ($this->getHttpCode() == 200);
    }

    /**
     * @return self
     */
    public function throwable(): self
    {
        if (!$this->isOk()) {
            throw new ApiException($this->getHttpCode(), $this->toObject()->error);
        }
        return $this;
    }
}
