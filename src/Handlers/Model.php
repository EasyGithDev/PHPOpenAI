<?php

namespace EasyGithDev\PHPOpenAI\Handlers;

use EasyGithDev\PHPOpenAI\Curl\CurlBuilder;
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
        $this->setRequest(CurlBuilder::get(
            $this->client->getRoute()->modelList(),
            headers:$this->client->getConfiguration()->getHeaders()
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
        $this->setRequest(CurlBuilder::get(
            $this->client->getRoute()->modelRetrieve($model),
            headers: array_merge(
                $this->client->getConfiguration()->getHeaders(),
                ContentTypeEnum::JSON->toHeaderArray()
            )
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
        $this->setRequest(CurlBuilder::delete(
            $this->client->getRoute()->modelDelete($model),
            headers: $this->client->getConfiguration()->getHeaders()
        ));

        return $this;
    }
}
