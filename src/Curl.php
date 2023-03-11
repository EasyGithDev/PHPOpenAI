<?php

namespace EasyGithDev\PHPOpenAI;

use Exception;

class Curl
{

    const CURL_GET = 'GET';
    const CURL_POST = 'POST';
    const CURL_PUT = 'PUT';
    const CURL_DELETE = 'DELETE';
    const CURL_PATCH = 'PATCH';

    protected ?\CurlHandle $ch = null;
    protected string $url = '';
    protected array $headers = [];
    protected string|array $payload;
    protected string $method = self::CURL_GET;
    protected bool $returnTransfer = true;

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
        if (empty($this->url)) {
            throw new Exception('Url is required');
        }
        
        curl_setopt($this->ch, CURLOPT_URL, $this->url);

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

        if (count($this->headers)) {
            curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->headers);
        }

        if ($this->returnTransfer) {
            curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, $this->returnTransfer);
        }
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
     * @return string
     */
    public function exec(): string
    {
        $this->prepare();

        $response = curl_exec($this->ch);

        if (curl_errno($this->ch)) {
            throw new \Exception('Curl error : ' . curl_error($this->ch));
        }

        $http_code = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);

        if ($http_code != intval(200)) {
            throw new \Exception('Api error : ' . $http_code);
        }

        return $response;
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
     * Set the value of url
     *
     * @return  self
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
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
     * Set the value of payload
     *
     * @return  self
     */
    public function setPayload(string|array $payload): self
    {
        $this->payload = $payload;
        $this->setMethod(self::CURL_POST);

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
}
