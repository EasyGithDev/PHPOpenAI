<?php

namespace EasyGithDev\PHPOpenAI\Files;

use EasyGithDev\PHPOpenAI\Curl\CurlRequest;
use EasyGithDev\PHPOpenAI\Curl\CurlResponse;

use Exception;

class File
{
    const END_POINT = '/files';

    protected CurlRequest $curl;


    /**
     * @param string $apiUrl
     * @param array $headers
     */
    function __construct(CurlRequest $curl)
    {
        $this->curl = $curl;
    }

    /**
     * @return CurlResponse
     */
    function list(): CurlResponse
    {
        $response =  $this->curl
            ->appendToUrl(self::END_POINT)
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
            ->appendToUrl(self::END_POINT)
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
            ->appendToUrl(self::END_POINT . '/' . $file_id)

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
            ->appendToUrl(self::END_POINT . '/' . $file_id)
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
            ->appendToUrl(self::END_POINT . '/' . $file_id . '/content')

            // ->verboseEnabled('debug.txt')
            ->exec();

        $this->curl->close();

        return $response;
    }
}
