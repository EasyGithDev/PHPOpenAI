<?php

namespace EasyGithDev\PHPOpenAI\Curl;

use EasyGithDev\PHPOpenAI\Exceptions\ApiException;
use EasyGithDev\PHPOpenAI\Exceptions\ClientException;

class CurlResponse implements \JsonSerializable
{
    public function __construct(protected array $infos)
    {
    }

    public function getStatusCode(): int
    {
        return $this->infos['curlinfo']['http_code'];
    }

    public function getReasonPhrase(): string
    {
        return '';
    }

    public function getHeaderLine(): string
    {
        return $this->infos['curlinfo']['content_type'];
    }

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
     * Return output body as an associative array
     * @return array
     */
    public function toArray(): array
    {
        $body = json_decode($this->infos['body'], true);

        if (\json_last_error()) {
            throw new ClientException(
                'Failed to parse JSON response body: ' . \json_last_error_msg()
            );
        }

        return $body;
    }

    /**
     * Return output body as an object
     * @return stdClass
     */
    public function toObject(): \stdClass
    {
        $body = json_decode($this->infos['body']);

        if (\json_last_error()) {
            throw new ClientException(
                'Failed to parse JSON response body: ' . \json_last_error_msg()
            );
        }

        return $body;
    }

    /**
     * Get the value of infos
     */
    public function getInfos(): array
    {
        return $this->infos;
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

    protected function getError(): \stdClass
    {
        $body = json_decode($this->infos['body']);

        if (\json_last_error()) {
            $err = new \stdClass();
            $err->message = $this->infos['body'];
            $err->type = '';
            $err->param = '';
            $err->code = '';
            return $err;
        }

        return $body->error;
    }
}
