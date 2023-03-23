<?php

namespace EasyGithDev\PHPOpenAI\Files;

use EasyGithDev\PHPOpenAI\Curl\CurlRequest;
use EasyGithDev\PHPOpenAI\Curl\CurlResponse;
use EasyGithDev\PHPOpenAI\Curl\Responses\FileResponse;
use Exception;

class File
{
    const END_POINT = '/files';




    /**
     * @param string $apiUrl
     * @param array $headers
     */
    function __construct(protected CurlRequest $curl, protected CurlResponse $response)
    {
    }

    /**
     * @return CurlResponse
     */
    function list(): FileResponse
    {
        $response =  $this->curl
            ->setUrl(self::END_POINT)
            ->exec();

        $this->curl->close();

        return $this->response->setInfos($response);
    }

    /**
     * @param string $file
     * @param string $purpose
     * 
     * @return CurlResponse
     */
    function create(string $file, string $purpose): FileResponse
    {

        if (!file_exists($file)) {
            throw new Exception("Unable to locate file: $file");
        }

        $payload =  [
            "file" => curl_file_create($file),
            "purpose" => $purpose,
        ];

        $response =  $this->curl
            ->setUrl(self::END_POINT)
            ->setMethod(CurlRequest::CURL_POST)
            ->setPayload(
                $payload
            )
            ->exec();

        $this->curl->close();

        return $this->response->setInfos($response);
    }

    /**
     * @param string $file_id
     * 
     * @return CurlResponse
     */
    function delete(string $file_id): FileResponse
    {

        if (empty($file_id)) {
            throw new Exception("file_id can not be empty");
        }

        $response =  $this->curl
            ->setUrl(self::END_POINT . '/' . $file_id)
            ->setMethod(CurlRequest::CURL_DELETE)
            ->exec();
        $this->curl->close();

        return $this->response->setInfos($response);
    }


    /**
     * @param string $file_id
     * 
     * @return CurlResponse
     */
    function retrieve(string $file_id): FileResponse
    {

        if (empty($file_id)) {
            throw new Exception("file_id can not be empty");
        }

        $response =  $this->curl
            ->setUrl(self::END_POINT . '/' . $file_id)
            ->exec();

        $this->curl->close();

        return $this->response->setInfos($response);
    }

    /**
     * @param string $file_id
     * 
     * @return CurlResponse
     */
    function download(string $file_id): FileResponse
    {
        if (empty($file_id)) {
            throw new Exception("file_id can not be empty");
        }

        $response =  $this->curl
            ->setUrl(self::END_POINT . '/' . $file_id . '/content')
            ->exec();

        $this->curl->close();

        return $this->response->setInfos($response);
    }
}
