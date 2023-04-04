<?php

namespace EasyGithDev\PHPOpenAI\Handlers;

use EasyGithDev\PHPOpenAI\OpenAIClient;
use EasyGithDev\PHPOpenAI\OpenAIHandler;

/**
 * [Description Model]
 */
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
     * @return self
     */
    public function list(): self
    {
        $this->setRequest($this->client->get(
            self::END_POINT,
        ));

        return $this;
    }

    /**
     * @param string $model
     *
     * @return self
     */
    public function retrieve(string $model): self
    {
        $this->setRequest($this->client->get(
            self::END_POINT . "/$model",
            null,
            ['Content-Type: application/json']
        ));

        return $this;
    }

    /**
     * @param string $model
     *
     * @return self
     */
    public function delete(string $model): self
    {
        $this->setRequest($this->client->delete(
            self::END_POINT . "/$model"
        ));

        return $this;
    }
}
