<?php

namespace EasyGithDev\PHPOpenAI\Handlers;

use EasyGithDev\PHPOpenAI\Curl\CurlRequest;
use EasyGithDev\PHPOpenAI\Curl\CurlResponse;
use EasyGithDev\PHPOpenAI\Curl\Responses\ModelResponse;
use EasyGithDev\PHPOpenAI\OpenAIClient;
use EasyGithDev\PHPOpenAI\OpenAIHandler;

class Model extends OpenAIHandler
{
    public const END_POINT = '/models';

    /**
     * @param  protected
     */
    public function __construct(protected OpenAIClient $client)
    {
    }

    /**
     * @return CurlResponse
     */
    public function list(): self
    {
        $this->request = $this->client->get(
            self::END_POINT,
        );

        return $this;
    }


    /**
     * @param string $model
     *
     * @return CurlResponse
     */
    public function retrieve(string $model): self
    {
        $this->request = $this->client->get(
            self::END_POINT . "/$model",
            null,
            ['Content-Type: application/json']
        );

        return $this;
    }

    public function delete(string $model): self
    {
        $this->request = $this->client->delete(
            self::END_POINT . "/$model"
        );

        return $this;
    }
}
