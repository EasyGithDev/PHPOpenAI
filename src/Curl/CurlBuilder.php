<?php

namespace EasyGithDev\PHPOpenAI\Curl;

/**
 * [Description CurlRequest]
 */
class CurlBuilder
{
    /**
     * Build a GET HTTP request
     * @param string $path
     * @param null $body
     * @param array $headers
     * @param array $params
     *
     * @return CurlRequest
     */
    public static function get(string $path, $body = null, array $headers = [], array $params = []): CurlRequest
    {
        $request = (new CurlRequest())
            ->setUrl($path)
            ->setMethod(CurlRequest::CURL_GET)
            ->setHeaders($headers);

        static::applyParams($request, $params);

        return $request;
    }

    /**
     * Build a POST HTTP request
     *
     * @param string $path
     * @param null $body
     * @param array $headers
     * @param array $params
     *
     * @return CurlRequest
     */
    public static function post(string $path, $body = null, array $headers = [], array $params = []): CurlRequest
    {
        $request = (new CurlRequest())
            ->setUrl($path)
            ->setMethod(CurlRequest::CURL_POST)
            ->setPayload($body)
            ->setHeaders($headers);

        static::applyParams($request, $params);

        return $request;
    }

    /**
     * Build a PUT HTTP request
     *
     * @param string $path
     * @param null $body
     * @param array $headers
     * @param array $params
     *
     * @return CurlRequest
     */
    public static function put(string $path, $body = null, array $headers = [], array $params = []): CurlRequest
    {
        return (new CurlRequest())
            ->setUrl($path)
            ->setMethod(CurlRequest::CURL_PUT)
            ->setPayload($body)
            ->setHeaders($headers);
    }

    /**
     * Build a DELETE HTTP request
     *
     * @param string $path
     * @param null $body
     * @param array $headers
     * @param array $params
     *
     * @return CurlRequest
     */
    public static function delete(string $path, $body = null, array $headers = [], array $params = []): CurlRequest
    {
        return (new CurlRequest())
            ->setUrl($path)
            ->setMethod(CurlRequest::CURL_DELETE)
            ->setPayload($body)
            ->setHeaders($headers);
    }

    /**
     * Apply the parameters to the CurlObject
     * @param CurlRequest $request
     * @param array $params
     *
     * @return void
     */
    protected static function applyParams(CurlRequest $request, array $params): void
    {
        array_walk($params, function ($value, $key) use ($request) {
            $request->$key($value);
        });
    }
}
