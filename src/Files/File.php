<?php

namespace EasyGithDev\PHPOpenAI\Files;

use EasyGithDev\PHPOpenAI\Curl;
use EasyGithDev\PHPOpenAI\Response;
use Exception;

class File
{
    const END_POINT = '/files';

    protected Curl $curl;
    protected string $apiUrl;
    protected array $headers = [];

    /**
     * @param string $apiUrl
     * @param array $headers
     */
    function __construct(string $apiUrl, array $headers)
    {
        $this->curl = new Curl;
        $this->apiUrl = $apiUrl;
        $this->headers = $headers;
    }

    /**
     * @return Response
     */
    function list(): Response
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
     * @return Response
     */
    function create(string $file, string $purpose): Response
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
     * @return Response
     */
    function delete(string $file_id): Response
    {

        if (empty($file_id)) {
            throw new Exception("file_id can not be empty");
        }

        $response =  $this->curl
            ->setUrl($this->apiUrl . self::END_POINT . '/' . $file_id)
            ->setHeaders(
                $this->headers
            )
            ->setMethod(Curl::CURL_DELETE)
            ->exec();

        $this->curl->close();

        return $response;
    }


    /**
     * @param string $file_id
     * 
     * @return Response
     */
    function retrieve(string $file_id): Response
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
     * @return Response
     */
    function download(string $file_id): Response
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
