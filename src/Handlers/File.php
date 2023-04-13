<?php

namespace EasyGithDev\PHPOpenAI\Handlers;

use EasyGithDev\PHPOpenAI\Curl\CurlBuilder;
use EasyGithDev\PHPOpenAI\Exceptions\ClientException;
use EasyGithDev\PHPOpenAI\OpenAIClient;
use EasyGithDev\PHPOpenAI\OpenAIHandler;
use EasyGithDev\PHPOpenAI\Validators\ApplicationOctetStreamValidator;

/**
 * [Description File]
 */
class File extends OpenAIHandler
{
    /**
     * @param  protected
     */
    public function __construct(protected OpenAIClient $client)
    {
    }

    public function list(): self
    {
        $this->setRequest(CurlBuilder::get(
            $this->client->getRoute()->fileList(),
            headers:$this->client->getConfiguration()->getHeaders(),
            params: $this->curlParams
        ));

        return $this;
    }


    /**
     * @param string $file
     * @param string $purpose
     *
     * @return self
     */
    public function create(string $file, string $purpose): self
    {
        if (!file_exists($file)) {
            throw new ClientException("Unable to locate file: $file");
        }

        $payload =  [
            "file" => curl_file_create($file),
            "purpose" => $purpose,
        ];

        $this->setRequest(CurlBuilder::post(
            $this->client->getRoute()->fileCreate(),
            $payload,
            $this->client->getConfiguration()->getHeaders(),
            $this->curlParams
        ));

        return $this;
    }


    /**
     * @param string $file_id
     *
     * @return self
     */
    public function delete(string $file_id): self
    {
        if (empty($file_id)) {
            throw new ClientException("file_id can not be empty");
        }

        $this->setRequest(CurlBuilder::delete(
            $this->client->getRoute()->fileDelete($file_id),
            headers:$this->client->getConfiguration()->getHeaders(),
            params:$this->curlParams
        ));

        return $this;
    }



    /**
     * @param string $file_id
     *
     * @return self
     */
    public function retrieve(string $file_id): self
    {
        if (empty($file_id)) {
            throw new ClientException("file_id can not be empty");
        }

        $this->setRequest(CurlBuilder::get(
            $this->client->getRoute()->fileRetrieve($file_id),
            headers:$this->client->getConfiguration()->getHeaders(),
            params: $this->curlParams
        ));

        return $this;
    }


    /**
     * @param string $file_id
     *
     * @return self
     */
    public function download(string $file_id): self
    {
        if (empty($file_id)) {
            throw new ClientException("file_id can not be empty");
        }

        $this->setRequest(CurlBuilder::get(
            $this->client->getRoute()->fileDownload($file_id),
            headers:$this->client->getConfiguration()->getHeaders(),
            params: $this->curlParams
        ));

        $this->contentTypeValidator = ApplicationOctetStreamValidator::class;

        return $this;
    }
}
