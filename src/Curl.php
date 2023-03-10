<?php

namespace EasyGithDev\PHPOpenAI;

class Curl
{
    protected ?\CurlHandle $ch = null;
    protected string $url = '';
    protected array $headers = [];
    protected string|array $payload;

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
        curl_setopt($this->ch, CURLOPT_URL, $this->url);

        if (!empty($this->payload)) {
            curl_setopt($this->ch, CURLOPT_POST, true);
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, $this->payload);
        }

        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
    }

    public function verboseEnabled(string $filename): self
    {
        $fp = fopen($filename, 'w');
        curl_setopt($this->ch, CURLOPT_VERBOSE, 1);
        curl_setopt($this->ch, CURLOPT_STDERR, $fp);

        return $this;
    }

    public function delete(): self
    {
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, "DELETE");

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

        return $this;
    }
}
