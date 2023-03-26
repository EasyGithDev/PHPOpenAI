<?php

namespace EasyGithDev\PHPOpenAI\Embeddings;

use EasyGithDev\PHPOpenAI\Curl\CurlRequest;
use EasyGithDev\PHPOpenAI\Models\ModelEnum;
use EasyGithDev\PHPOpenAI\Curl\CurlResponse;
use EasyGithDev\PHPOpenAI\Curl\Responses\EmbeddingResponse;
use EasyGithDev\PHPOpenAI\OpenAIApi;
use EasyGithDev\PHPOpenAI\OpenAIModel;

class Embedding extends OpenAIModel
{
    public const END_POINT = '/embeddings';

    public function __construct(protected ?OpenAIApi $client = null)
    {
    }

    /**
     * @param ModelEnum $model
     * @param string|array $input
     * @param string $user
     *
     * @return CurlResponse
     */
    public function create(ModelEnum $model, string|array $input, string $user = ''): self
    {
        if (empty($input)) {
            throw new \Exception("Input is required");
        }

        $payload =  [
            "model" => $model->value,
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
