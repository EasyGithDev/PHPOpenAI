<?php

namespace EasyGithDev\PHPOpenAI\Curl;

use Exception;

class CurlRequest
{
    public const CURL_GET = 'GET';
    public const CURL_POST = 'POST';
    public const CURL_PUT = 'PUT';
    public const CURL_DELETE = 'DELETE';
    public const CURL_PATCH = 'PATCH';

    protected ?\CurlHandle $ch = null;
    protected string $baseUrl = '';
    protected string $url = '';
    protected array $baseHeaders = [];
    protected array $headers = [];
    protected string|array|null $payload = null;
    protected string $method = self::CURL_GET;
    protected bool $returnTransfer = true;
    protected int $connecttimeout = 0;
    protected int $timeout = 10;

    /**
     */
    public function __construct()
    {
        $this->ch = curl_init();
    }

    /**
     * @return [type]
     */
    public function __destruct()
    {
        $this->close();
    }

    /**
     * @return void
     */
    protected function prepare(): void
    {
        $url = $this->baseUrl . $this->url;
        $headers = array_merge($this->baseHeaders, $this->headers);

        if (empty($url)) {
            throw new Exception('Url is required');
        }

        curl_setopt($this->ch, CURLOPT_URL, $url);

        switch ($this->method) {
            case self::CURL_POST:
                curl_setopt($this->ch, CURLOPT_POST, true);
                curl_setopt($this->ch, CURLOPT_POSTFIELDS, $this->payload);
                break;
            case self::CURL_DELETE:
            case self::CURL_PUT:
            case self::CURL_PATCH:
                curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, $this->method);
                break;
        }

        if (count($headers)) {
            curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers);
        }

        if ($this->returnTransfer) {
            curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, $this->returnTransfer);
        }

        curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, $this->connecttimeout);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, $this->timeout); //timeout in seconds
    }

    public function verboseEnabled(string $filename): self
    {
        $fp = fopen($filename, 'w');
        curl_setopt($this->ch, CURLOPT_VERBOSE, 1);
        curl_setopt($this->ch, CURLOPT_STDERR, $fp);

        return $this;
    }

    public function setMethod(string $method): self
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return CurlResponse
     */
    public function exec(): array
    {
        $this->prepare();

        $buffer = curl_exec($this->ch);

        if (curl_errno($this->ch)) {
            throw new \Exception('CurlRequest error : ' . curl_error($this->ch));
        }

        $curlinfo = curl_getinfo($this->ch);

        $infos = [
            'input' => [
                'payload' => $this->payload
            ],
            'output' => [
                'curlinfo' => $curlinfo,
                'buffer' => $buffer
            ]
        ];

        return $infos;
    }

    /**
     * @return void
     */
    public function close(): void
    {
        if (!is_null($this->ch)) {
            curl_close($this->ch);
        }
    }


    /**
     * Set the value of headers
     *
     * @return  self
     */
    public function setHeaders(array $headers): self
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * @param array $additionalHeader
     *
     * @return self
     */
    public function addHeaders(array $additionalHeader): self
    {
        if (!in_array($additionalHeader, $this->headers)) {
            $this->headers = array_merge($this->headers, $additionalHeader);
        }

        return $this;
    }

    /**
     * Set the value of payload
     *
     * @return  self
     */
    public function setPayload(string|array $payload): self
    {
        $this->payload = $payload;

        return $this;
    }

    /**
     * Set the value of returnTransfer
     *
     * @return  self
     */
    public function setReturnTransfer(bool $returnTransfer): self
    {
        $this->returnTransfer = $returnTransfer;

        return $this;
    }

    /**
     * Set the value of timeout
     *
     * @return  self
     */
    public function setTimeout($timeout): self
    {
        $this->timeout = $timeout;

        return $this;
    }

    /**
     * Set the value of connecttimeout
     *
     * @return  self
     */
    public function setConnecttimeout($connecttimeout): self
    {
        $this->connecttimeout = $connecttimeout;

        return $this;
    }

    /**
     * Get the value of baseUrl
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * Set the value of baseUrl
     *
     * @return  self
     */
    public function setBaseUrl(string $baseUrl): self
    {
        $this->baseUrl = $baseUrl;

        return $this;
    }

    /**
     * Get the value of url
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Set the value of url
     *
     * @return  self
     */
    public function setUrl($url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Set the value of baseHeaders
     *
     * @return  self
     */
    public function setBaseHeaders($baseHeaders): self
    {
        $this->baseHeaders = $baseHeaders;

        return $this;
    }
}
