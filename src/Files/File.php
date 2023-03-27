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

    public function list(): self
    {
        $this->request = $this->client->get(
            self::END_POINT
        );

        return $this;
    }


    public function create(string $file, string $purpose): self
    {
        if (!file_exists($file)) {
            throw new Exception("Unable to locate file: $file");
        }

        $payload =  [
            "file" => curl_file_create($file),
            "purpose" => $purpose,
        ];

        $this->request = $this->client->post(
            self::END_POINT,
            $payload
        );

        return $this;
    }


    public function delete(string $file_id): self
    {
        if (empty($file_id)) {
            throw new Exception("file_id can not be empty");
        }

        $this->request = $this->client->delete(
            self::END_POINT . '/' . $file_id

        );

        return $this;
    }



    public function retrieve(string $file_id): self
    {
        if (empty($file_id)) {
            throw new Exception("file_id can not be empty");
        }

        $this->request = $this->client->get(
            self::END_POINT . '/' . $file_id
        );

        return $this;
    }


    public function download(string $file_id): self
    {
        if (empty($file_id)) {
            throw new Exception("file_id can not be empty");
        }

        $this->request = $this->client->get(
            self::END_POINT . '/' . $file_id . '/content'
        );

        return $this;
    }
}
