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

        if (isset($params['stream']) && $params['stream']) {
            $request->setCallback($params['callback']);
        }

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

        if (isset($params['stream']) && $params['stream']) {
            $request->setCallback($params['callback']);
        }

        if (isset($params['timeout']) && $params['timeout']) {
            $request->setTimeout($params['timeout']);
        }

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
}
