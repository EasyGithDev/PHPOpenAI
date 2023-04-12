<?php

namespace EasyGithDev\PHPOpenAI\Handlers;

use EasyGithDev\PHPOpenAI\Helpers\ModelEnum;
use EasyGithDev\PHPOpenAI\Exceptions\ClientException;
use EasyGithDev\PHPOpenAI\Helpers\ContentTypeEnum;
use EasyGithDev\PHPOpenAI\OpenAIClient;
use EasyGithDev\PHPOpenAI\OpenAIHandler;

/**
 * [Description Embedding]
 */
class Embedding extends OpenAIHandler
{
    public function __construct(protected OpenAIClient $client)
    {
    }

    /**
     * @param ModelEnum|string $model
     * @param string|array $input
     * @param string $user
     *
     * @return self
     */
    public function create(ModelEnum|string $model, string|array $input, string $user = ''): self
    {
        if (empty($model)) {
            throw new ClientException("Model can not be empty");
        }

        if (empty($input)) {
            throw new ClientException("Input is required");
        }

        $payload =  [
            "model" => is_string($model) ? $model : $model->value,
            "input" => $input,
        ];

        if (!empty($user)) {
            $payload["user"] = $user;
        }
        $this->setRequest($this->client->post(
            $this->client->getRoute()->embeddingCreate(),
            json_encode($payload),
            ContentTypeEnum::JSON->toHeaderArray()
        ));

        return $this;
    }
}
