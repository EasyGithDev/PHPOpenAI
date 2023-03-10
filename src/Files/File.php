<?php

namespace EasyGithDev\PHPOpenAI\Files;

use EasyGithDev\PHPOpenAI\Curl;
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
     * @return string
     */
    function list(): string
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

    function create(
        string $file,
        string $purpose,
    ) {

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
                json_encode($payload)
            )
            ->exec();

        $this->curl->close();

        return $response;
    }

    function delete(
        string $file_id,
    ) {
        $response =  $this->curl
            ->setUrl($this->apiUrl . self::END_POINT . '/' . $file_id)
            ->setHeaders(
                $this->headers
            )
            ->delete()
            ->exec();

        $this->curl->close();

        return $response;
    }


    function retrieve(
        string $file_id,
    ) {

        $response =  $this->curl
            ->setUrl($this->apiUrl . self::END_POINT . '/' . $file_id)
            ->setHeaders(
                $this->headers
            )
            ->exec();

        $this->curl->close();

        return $response;
    }

    function download(
        string $file_id,
    ) {
        $response =  $this->curl
            ->setUrl($this->apiUrl . self::END_POINT . '/' . $file_id . '/content')
            ->setHeaders(
                $this->headers
            )
            ->exec();

        $this->curl->close();

        return $response;
    }
}
