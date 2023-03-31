<?php

namespace EasyGithDev\PHPOpenAI\Handlers;

use EasyGithDev\PHPOpenAI\Helpers\ModelEnum;
use EasyGithDev\PHPOpenAI\Curl\CurlResponse;
use EasyGithDev\PHPOpenAI\Exceptions\ClientException;
use EasyGithDev\PHPOpenAI\OpenAIClient;
use EasyGithDev\PHPOpenAI\OpenAIHandler;

class Embedding extends OpenAIHandler
{
    public const END_POINT = '/embeddings';

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
        $this->request = $this->client->post(
            self::END_POINT,
            json_encode($payload),
            ['Content-Type: application/json']
        );

        return $this;
    }
}
