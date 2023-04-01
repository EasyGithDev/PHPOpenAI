<?php

namespace EasyGithDev\PHPOpenAI\Handlers;

use EasyGithDev\PHPOpenAI\Exceptions\ClientException;
use EasyGithDev\PHPOpenAI\OpenAIClient;
use EasyGithDev\PHPOpenAI\OpenAIHandler;

/**
 * [Description File]
 */
class File extends OpenAIHandler
{
    public const END_POINT = '/files';


    /**
     * @param  protected
     */
    public function __construct(protected OpenAIClient $client)
    {
    }

    public function list(): self
    {
        $this->request = $this->client->get(
            self::END_POINT
        );

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

        $this->request = $this->client->post(
            self::END_POINT,
            $payload
        );

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

        $this->request = $this->client->delete(
            self::END_POINT . '/' . $file_id
        );

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

        $this->request = $this->client->get(
            self::END_POINT . '/' . $file_id
        );

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

        $this->request = $this->client->get(
            self::END_POINT . '/' . $file_id . '/content'
        );

        return $this;
    }
}
