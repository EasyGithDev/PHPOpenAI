<?php

namespace EasyGithDev\PHPOpenAI\Embeddings;

use EasyGithDev\PHPOpenAI\Curl\CurlRequest;
use EasyGithDev\PHPOpenAI\Models\ModelEnum;
use EasyGithDev\PHPOpenAI\Curl\CurlResponse;
use EasyGithDev\PHPOpenAI\Curl\Responses\EmbeddingResponse;

class Embedding
{
    const END_POINT = '/embeddings';

    /**
     * @param string $apiUrl
     * @param array $headers
     */
    function __construct(protected CurlRequest $curl, protected CurlResponse $response)
    {
    }

    /**
     * @param ModelEnum $model
     * @param string|array $input
     * @param string $user
     * 
     * @return CurlResponse
     */
    function create(ModelEnum $model, string|array $input, string $user = ''): EmbeddingResponse
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

        $response =  $this->curl
            ->setUrl(self::END_POINT)
            ->setMethod(CurlRequest::CURL_POST)
            ->setPayload(
                json_encode($payload)
            )
            ->setHeaders(['Content-Type: application/json'])
            ->exec();

        $this->curl->close();

        return $this->response->setInfos($response);
    }
}
