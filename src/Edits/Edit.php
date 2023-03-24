<?php

namespace EasyGithDev\PHPOpenAI\Edits;

use EasyGithDev\PHPOpenAI\Curl\CurlRequest;
use EasyGithDev\PHPOpenAI\Models\ModelEnum;
use EasyGithDev\PHPOpenAI\Curl\CurlResponse;
use EasyGithDev\PHPOpenAI\Curl\Responses\EditResponse;
use EasyGithDev\PHPOpenAI\OpenAIApi;
use EasyGithDev\PHPOpenAI\OpenAIModel;

class Edit extends OpenAIModel
{
    public const END_POINT = '/edits';




    /**
     * @param string $apiUrl
     * @param array $headers
     */
    public function __construct(protected ?OpenAIApi $client = null)
    {
        $this->request = new CurlRequest();
        if (!is_null($this->client)) {
            $this->request
                ->setBaseHeaders($this->client->getConfiguration()->getCurlHeaders())
                ->setBaseUrl($this->client->getConfiguration()->getApiUrl());
        }
        $this->response = new EditResponse();
    }

    public function create(
        string $instruction,
        ModelEnum|string $model,
        string $input = '',
        float $temperature = 1.0,
        float $top_p = 1.0,
        int $n = 1,
    ): EditResponse {
        if (empty($instruction)) {
            throw new \Exception("Instruction can not be empty");
        }

        if ($temperature < 0 or $temperature > 2) {
            throw new \Exception("Temperature to use, between 0 and 2");
        }

        if ($top_p < 0 or $top_p > 2) {
            throw new \Exception("Nucleus sampling to use, between 0 and 2");
        }

        if ($n < 1 or $n > 10) {
            throw new \Exception('$n is between 1 and 10');
        }

        $payload =  [
            "instruction" => $instruction,
            "model" => is_string($model) ? $model : $model->value,
            "input" => $input,
            "temperature" => $temperature,
            "top_p" => $top_p,
            "n" => $n,
        ];

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
