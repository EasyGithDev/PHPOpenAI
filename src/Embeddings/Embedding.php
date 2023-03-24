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
        $this->request = new CurlRequest();
        if (!is_null($this->client)) {
            $this->request->setBaseHeaders($this->client->getConfiguration()->getCurlHeaders())
                ->setBaseUrl($this->client->getConfiguration()->getApiUrl());
        }
        $this->response = new EmbeddingResponse();
    }

    /**
     * @param ModelEnum $model
     * @param string|array $input
     * @param string $user
     *
     * @return CurlResponse
     */
    public function create(ModelEnum $model, string|array $input, string $user = ''): EmbeddingResponse
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

        $response =  $this->request
            ->setUrl(self::END_POINT)
            ->setMethod(CurlRequest::CURL_POST)
            ->setPayload(
                json_encode($payload)
            )
            ->setHeaders(['Content-Type: application/json'])
            ->exec();

        $this->request->close();

        return $this->response->setInfos($response);
    }
}
