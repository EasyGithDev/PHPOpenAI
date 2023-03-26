<?php

namespace EasyGithDev\PHPOpenAI\Files;

use EasyGithDev\PHPOpenAI\Curl\CurlRequest;
use EasyGithDev\PHPOpenAI\Curl\CurlResponse;
use EasyGithDev\PHPOpenAI\Curl\Responses\FileResponse;
use EasyGithDev\PHPOpenAI\OpenAIApi;
use EasyGithDev\PHPOpenAI\OpenAIModel;
use Exception;

class File extends OpenAIModel
{
    public const END_POINT = '/files';


    /**
     * @param  protected
     */
    public function __construct(protected ?OpenAIApi $client = null)
    {
 
    }

    /**
     * @return CurlResponse
     */
    public function list(): FileResponse
    {
        $response =  $this->request->setBaseHeaders($this->client->getConfiguration()->getCurlHeaders())
            ->setBaseUrl($this->client->getConfiguration()->getApiUrl())
            ->setUrl(self::END_POINT)
            ->exec();

        $this->request->close();

        return $this->response->setInfos($response);
    }

    /**
     * @param string $file
     * @param string $purpose
     *
     * @return CurlResponse
     */
    public function create(string $file, string $purpose): FileResponse
    {
        if (!file_exists($file)) {
            throw new Exception("Unable to locate file: $file");
        }

        $payload =  [
            "file" => curl_file_create($file),
            "purpose" => $purpose,
        ];

        $response =  $this->request->setBaseHeaders($this->client->getConfiguration()->getCurlHeaders())
            ->setBaseUrl($this->client->getConfiguration()->getApiUrl())
            ->setUrl(self::END_POINT)
            ->setMethod(CurlRequest::CURL_POST)
            ->setPayload(
                $payload
            )
            ->exec();

        $this->request->close();

        return $this->response->setInfos($response);
    }

    /**
     * @param string $file_id
     *
     * @return CurlResponse
     */
    public function delete(string $file_id): FileResponse
    {
        if (empty($file_id)) {
            throw new Exception("file_id can not be empty");
        }

        $response =  $this->request
            ->setUrl(self::END_POINT . '/' . $file_id)
            ->setMethod(CurlRequest::CURL_DELETE)
            ->exec();
        $this->request->close();

        return $this->response->setInfos($response);
    }


    /**
     * @param string $file_id
     *
     * @return CurlResponse
     */
    public function retrieve(string $file_id): FileResponse
    {
        if (empty($file_id)) {
            throw new Exception("file_id can not be empty");
        }

        $response =  $this->request->setBaseHeaders($this->client->getConfiguration()->getCurlHeaders())
            ->setBaseUrl($this->client->getConfiguration()->getApiUrl())
            ->setUrl(self::END_POINT . '/' . $file_id)
            ->exec();

        $this->request->close();

        return $this->response->setInfos($response);
    }

    /**
     * @param string $file_id
     *
     * @return CurlResponse
     */
    public function download(string $file_id): FileResponse
    {
        if (empty($file_id)) {
            throw new Exception("file_id can not be empty");
        }

        $response =  $this->request->setBaseHeaders($this->client->getConfiguration()->getCurlHeaders())
            ->setBaseUrl($this->client->getConfiguration()->getApiUrl())
            ->setUrl(self::END_POINT . '/' . $file_id . '/content')
            ->exec();

        $this->request->close();

        return $this->response->setInfos($response);
    }
}
