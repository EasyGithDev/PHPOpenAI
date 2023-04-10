<?php

namespace EasyGithDev\PHPOpenAI\Curl;

use EasyGithDev\PHPOpenAI\Exceptions\ApiException;

/**
 * [Description CurlResponse]
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
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->infos;
    }

    /**
     * @return string
     * Depreciate, it will be removed
     *
     */
    public function getError(): string
    {
        $body = json_decode($this->getBody());

        if (\json_last_error()) {
            return \sprintf(
                'status: %s\nmessage: %s\ntype: %s\param: %s\ncode: %s\n',
                $this->getStatusCode(),
                $this->getBody(),
                '',
                '',
                '',
            );
        }

        return \sprintf(
            'status: %s\nmessage: %s\ntype: %s\param: %s\ncode: %s\n',
            $this->getStatusCode(),
            $body->error->message,
            $body->error->type,
            $body->error->param,
            $body->error->code,
        );
    }


    /**
     * Return output body as an associative array
     * Depreciate, it will be removed
     *
     * @return array
     */
    public function toArray(): array
    {
        $body = json_decode($this->infos['body'], true);

        if (\json_last_error()) {
            throw new ApiException(
                'Failed to parse JSON response body: ' . \json_last_error_msg()
            );
        }

        return $body;
    }

    /**
     * Return output body as an object
     * Depreciate, it will be removed
     *
     * @return \stdClass
     */
    public function toObject(): \stdClass
    {
        $body = json_decode($this->infos['body']);

        if (\json_last_error()) {
            throw new ApiException(
                'Failed to parse JSON response body: ' . \json_last_error_msg()
            );
        }

        return $body;
    }

    /**
     * Depreciate, it will be removed
     * @return bool
     */
    public function isStatusOk(): bool
    {
        return ($this->getStatusCode() == 200);
    }

    /**
     * Depreciate, it will be removed
     * @return bool
     */
    public function isContentTypeOk(): bool
    {
        $contentType = mb_strtolower($this->getHeaderLine('Content-Type'));
        $url = $this->getInfos()['curlinfo']['url'];
        if (preg_match('/\/files\/file-.*\/content/', $url)) {
            if (substr($contentType, 0, 24) !== 'application/octet-stream' && mb_strlen($contentType) !== 0) {
                return false;
            }
        } elseif (preg_match('/\/audio/', $url)) {
            if (substr($contentType, 0, 10) !== 'text/plain' && mb_strlen($contentType) !== 0) {
                return false;
            }
        } else {
            if (substr($contentType, 0, 16) !== 'application/json' && mb_strlen($contentType) !== 0) {
                return false;
            }
        }

        return true;
    }

    /**
     * Depreciate, it will be removed
     * @return self
     */
    public function throwable(): self
    {
        if (!$this->isStatusOk()) {
            throw new ApiException($this->getError());
        }
        if (!$this->isContentTypeOk()) {
            throw new ApiException(\sprintf('Unsupported content type: %s', $this->getHeaderLine('Content-Type')));
        }
        return $this;
    }
}
