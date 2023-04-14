<?php

namespace EasyGithDev\PHPOpenAI\Curl;

use Closure;

/**
 * CurlRequest provides a simple and convenient interface
 * for making HTTP requests using the cURL library.
 *
 * The class allows making GET, POST, PUT, DELETE, and PATCH requests,
 * and can handle request headers and payloads.
 */
class CurlRequest
{
    public const CURL_GET = 'GET';
    public const CURL_POST = 'POST';
    public const CURL_PUT = 'PUT';
    public const CURL_DELETE = 'DELETE';
    public const CURL_PATCH = 'PATCH';

    /**
     * @var \CurlHandle|null|null
     */
    protected ?\CurlHandle $ch = null;

    /**
     * @var string
     */
    protected string $url = '';

    /**
     * @var array
     */
    protected array $headers = [];

    /**
     * @var string|array|null
     */
    protected string|array|null $payload = null;

    /**
     * @var string
     */
    protected string $method = self::CURL_GET;

    /**
     * @var bool
     */
    protected bool $returnTransfer = true;

    /**
     * @var int
     */
    protected int $connecttimeout = 0;

    /**
     * @var int
     */
    protected int $timeout = 10;

    /**
     * @var null
     */
    protected ?Closure $writeFunction = null;

    /**
     * @var bool
     */
    protected bool $followLocation = true;

    /**
     * @var int
     */
    protected int $maxRedirect = 10;

    /**
     * @var bool
     */
    protected bool $debug = false;

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
            throw new \Exception('Url is required');
        }

        curl_setopt($this->ch, CURLOPT_URL, $this->url);

        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, $this->method);

        if (!is_null($this->payload)) {
            curl_setopt($this->ch, CURLOPT_POST, true);
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, $this->payload);
        }

        if (count($this->headers)) {
            curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->headers);
        }

        if ($this->returnTransfer) {
            curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, $this->returnTransfer);
        }

        if (!is_null($this->writeFunction)) {
            curl_setopt($this->ch, CURLOPT_WRITEFUNCTION, $this->writeFunction);
        }

        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, $this->followLocation);
        curl_setopt($this->ch, CURLOPT_MAXREDIRS, $this->maxRedirect);


        curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, $this->connecttimeout);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, $this->timeout); //timeout in seconds
    }

    /**
     * Enable / disable the debug mode
     * @return self
     */
    public function setDebug(bool $debug): self
    {
        $this->debug = $debug;
        return $this;
    }

    /**
     * Start the debug mode
     * @return mixed
     */
    protected function startDebug(): mixed
    {
        //open a temporary stream to output the curl log, which would normally got to STDERR
        $err = fopen("php://temp", "w+");
        curl_setopt($this->ch, CURLOPT_VERBOSE, true);
        curl_setopt($this->ch, CURLOPT_STDERR, $err);

        return $err;
    }

    /**
     * Stop the debug mode and return
     * the result as a string
     * @param mixed $err
     *
     * @return string
     */
    protected function stopDebug(mixed $err): string
    {
        //rewind the temp stream and put it into a string
        rewind($err);
        $log = stream_get_contents($err);
        fclose($err);
        return $log;
    }

    /**
     * @return array
     */
    public function exec(): array
    {
        $this->prepare();

        if ($this->debug) {
            $handle = $this->startDebug();
        }

        $body = curl_exec($this->ch);

        if (curl_errno($this->ch)) {
            throw new \RuntimeException('CurlRequest error : ' . curl_error($this->ch));
        }

        $curlLog = '';
        if ($this->debug) {
            $curlLog = $this->stopDebug($handle);
        }

        $curlInfo = curl_getinfo($this->ch);

        return [
            'curlinfo' => $curlInfo,
            'body' => $body,
            'curllog' => $curlLog
        ];
    }

    /**
     * @return void
     */
    public function close(): void
    {
        if (!is_null($this->ch)) {
            curl_close($this->ch);
            $this->ch = null;
        }
    }

    /**
     * @param string $method
     *
     * @return self
     */
    public function setMethod(string $method): self
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @param Closure $writeFunction
     *
     * @return self
     */
    public function setStream(Closure $writeFunction): self
    {
        $this->writeFunction = $writeFunction;
        return $this;
    }

    /**
     * Set the value of headers
     *
     * @param array $headers
     *
     * @return self
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
     * @param string|array|null $payload
     *
     * @return self
     */
    public function setPayload(string|array|null $payload): self
    {
        $this->payload = $payload;

        return $this;
    }

    /**
     * Set the value of returnTransfer
     *
     * @param bool $returnTransfer
     *
     * @return self
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
     * Get the value of url
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Set the value of url
     * @param string $url
     *
     * @return self
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Set the value of followLocation
     *
     * @param bool $followLocation
     *
     * @return self
     */
    public function setFollowLocation(bool $followLocation): self
    {
        $this->followLocation = $followLocation;

        return $this;
    }

    /**
     * Set the value of maxRedirect
     * @param int $maxRedirect
     *
     * @return self
     */
    public function setMaxRedirect(int $maxRedirect): self
    {
        $this->maxRedirect = $maxRedirect;

        return $this;
    }

    public function __call($method, $args)
    {
        $method = "set$method";
        if (method_exists($this, $method)) {
            $this->$method($args[0]);
        }
    }
}
