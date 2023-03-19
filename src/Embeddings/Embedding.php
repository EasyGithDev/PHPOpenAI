<?php

namespace EasyGithDev\PHPOpenAI\Embeddings;

use EasyGithDev\PHPOpenAI\Curl;
use EasyGithDev\PHPOpenAI\Models\ModelEnum;

class Embedding
{
    const END_POINT = '/embeddings';

    protected Curl $curl;
    protected string $apiUrl;
    protected array $headers = [];

    /**
     * @param string $apiUrl
     * @param array $headers
     */
    function __construct(string $apiUrl, array $headers)
    {
        $this->curl = new Curl;
        $this->apiUrl = $apiUrl;
        $this->headers = $headers;
    }

    function create(
        ModelEnum $model,
        string|array $input,
        string $user = ''
    ): string {

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
            ->setUrl($this->apiUrl . self::END_POINT)
            ->setHeaders(
                $this->headers
            )
            ->setPayload(
                json_encode($payload)
            )
            ->exec();

        $this->curl->close();

        return $response;
    }
}
