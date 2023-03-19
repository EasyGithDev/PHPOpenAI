<?php

namespace EasyGithDev\PHPOpenAI\Files;

use EasyGithDev\PHPOpenAI\Curl\CurlRequest;
use EasyGithDev\PHPOpenAI\Curl\CurlResponse;

use Exception;

class File
{
    const END_POINT = '/files';

    protected CurlRequest $curl;
    protected string $apiUrl;
    protected array $headers = [];

    /**
     * @param string $apiUrl
     * @param array $headers
     */
    function __construct(string $apiUrl, array $headers)
    {
        $this->curl = new CurlRequest;
        $this->apiUrl = $apiUrl;
        $this->headers = $headers;
    }

    /**
     * @return CurlResponse
     */
    function list(): CurlResponse
    {
        $response =  $this->curl
            ->setUrl($this->apiUrl . self::END_POINT)
            ->setHeaders(
                $this->headers
            )
            ->exec();

        $this->curl->close();

        return $response;
    }

    /**
     * @param string $file
     * @param string $purpose
     * 
     * @return CurlResponse
     */
    function create(string $file, string $purpose): CurlResponse
    {

        if (!file_exists($file)) {
            throw new Exception("Unable to locate file: $file");
        }

        $payload =  [
            "file" => curl_file_create($file),
            "purpose" => $purpose,
        ];

        $response =  $this->curl
            ->setUrl($this->apiUrl . self::END_POINT)
            ->setHeaders(
                $this->headers
            )
            ->setPayload(
                $payload
            )
            // ->verboseEnabled(__DIR__.'debug.txt')
            ->exec();

        $this->curl->close();

        return $response;
    }

    /**
     * @param string $file_id
     * 
     * @return CurlResponse
     */
    function delete(string $file_id): CurlResponse
    {

        if (empty($file_id)) {
            throw new Exception("file_id can not be empty");
        }

        $response =  $this->curl
            ->setUrl($this->apiUrl . self::END_POINT . '/' . $file_id)
            ->setHeaders(
                $this->headers
            )
            ->setMethod(CurlRequest::CURL_DELETE)
            ->exec();

        $this->curl->close();

        return $response;
    }


    /**
     * @param string $file_id
     * 
     * @return CurlResponse
     */
    function retrieve(string $file_id): CurlResponse
    {

        if (empty($file_id)) {
            throw new Exception("file_id can not be empty");
        }

        $response =  $this->curl
            ->setUrl($this->apiUrl . self::END_POINT . '/' . $file_id)
            ->setHeaders(
                $this->headers
            )
            ->exec();

        $this->curl->close();

        return $response;
    }

    /**
     * @param string $file_id
     * 
     * @return CurlResponse
     */
    function download(string $file_id): CurlResponse
    {

        if (empty($file_id)) {
            throw new Exception("file_id can not be empty");
        }

        $response =  $this->curl
            ->setUrl($this->apiUrl . self::END_POINT . '/' . $file_id . '/content')
            ->setHeaders(
                $this->headers
            )
            // ->verboseEnabled('debug.txt')
            ->exec();

        $this->curl->close();

        return $response;
    }
}
