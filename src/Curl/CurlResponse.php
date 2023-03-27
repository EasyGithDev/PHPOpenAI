<?php

namespace EasyGithDev\PHPOpenAI\Curl;

use EasyGithDev\PHPOpenAI\Exceptions\ApiException;
use EasyGithDev\PHPOpenAI\Exceptions\ClientException;
use JsonSerializable;
use stdClass;

class CurlResponse implements JsonSerializable
{
    public function __construct(protected ?array $infos = null)
    {
    }

    public function getStatusCode(): int
    {
        return $this->infos['output']['curlinfo']['http_code'];
    }

    public function getReasonPhrase(): string
    {
        return '';
    }

    public function getHeaderLine(): string
    {
        return $this->infos['output']['curlinfo']['content_type'];
    }

    public function getBody(): string
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
    public function isStatusOk(): bool
    {
        return ($this->getStatusCode() == 200);
    }

    public function isContentTypeOk(): bool
    {
        $contentType = mb_strtolower($this->getHeaderLine('Content-Type'));
        if (substr($contentType, 0, 16) !== 'application/json' && mb_strlen($contentType) !== 0) {
            return false;
        }
        return true;
    }

    /**
     * @return self
     */
    public function throwable(): self
    {
        if (!$this->isStatusOk()) {
            throw new ApiException($this->getStatusCode(), $this->getError());
        }
        if (!$this->isContentTypeOk()) {
            throw new ClientException(\sprintf('Unsupported content type: %s', $this->getHeaderLine('Content-Type')));
        }
        return $this;
    }

    protected function getError(): stdClass
    {
        if (!isset($this->toObject()->error)) {
            $err = new stdClass();
            $err->message = $this->infos['output']['buffer'];
            $err->type = '';
            $err->param = '';
            $err->code = '';
            return $err;
        }
        return $this->toObject()->error;
    }
}
