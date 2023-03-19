<?php

namespace EasyGithDev\PHPOpenAI\Curl;

use stdClass;

class CurlResponse
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

    public function __toString(): string
    {
        return $this->infos['output']['buffer'];
    }

    public function toArray(): array
    {
        return json_decode($this->infos['output']['buffer'], true);
    }

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
}
