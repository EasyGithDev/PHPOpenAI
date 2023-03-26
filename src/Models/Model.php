<?php

namespace EasyGithDev\PHPOpenAI\Models;

use EasyGithDev\PHPOpenAI\Curl\CurlRequest;
use EasyGithDev\PHPOpenAI\Curl\CurlResponse;
use EasyGithDev\PHPOpenAI\Curl\Responses\ModelResponse;
use EasyGithDev\PHPOpenAI\OpenAIApi;
use EasyGithDev\PHPOpenAI\OpenAIModel;

class Model extends OpenAIModel
{
    public const END_POINT = '/models';

    /**
     * @param  protected
     */
    public function __construct(protected ?OpenAIApi $client = null)
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
