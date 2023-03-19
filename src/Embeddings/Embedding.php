<?php

namespace EasyGithDev\PHPOpenAI\Embeddings;

use EasyGithDev\PHPOpenAI\Curl\CurlRequest;
use EasyGithDev\PHPOpenAI\Models\ModelEnum;
use EasyGithDev\PHPOpenAI\Curl\CurlResponse;


class Embedding
{
    const END_POINT = '/embeddings';

    protected CurlRequest $curl;


    /**
     * @param string $apiUrl
     * @param array $headers
     */
    function __construct(CurlRequest $curl)
    {
        $this->curl = $curl;
       
    }

    /**
     * @param ModelEnum $model
     * @param string|array $input
     * @param string $user
     * 
     * @return CurlResponse
     */
    function create(ModelEnum $model, string|array $input, string $user = ''): CurlResponse
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
            ->appendToUrl( self::END_POINT)
            ->setPayload(
                json_encode($payload)
            )
            ->exec();

        $this->curl->close();

        return $response;
    }
}
