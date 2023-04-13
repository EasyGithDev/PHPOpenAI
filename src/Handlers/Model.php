<?php

namespace EasyGithDev\PHPOpenAI\Handlers;

use EasyGithDev\PHPOpenAI\Helpers\ContentTypeEnum;
use EasyGithDev\PHPOpenAI\OpenAIClient;
use EasyGithDev\PHPOpenAI\OpenAIHandler;

/**
 * [Description Model]
 */
class Model extends OpenAIHandler
{
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
            $this->client->getRoute()->modelList(),
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
            $this->client->getRoute()->modelRetrieve($model),
            null,
            ContentTypeEnum::JSON->toHeaderArray()
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
            $this->client->getRoute()->modelDelete($model),
        ));

        return $this;
    }
}
