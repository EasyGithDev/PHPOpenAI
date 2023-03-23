<?php

namespace EasyGithDev\PHPOpenAI\Moderations;

use EasyGithDev\PHPOpenAI\Curl\CurlRequest;
use EasyGithDev\PHPOpenAI\Curl\CurlResponse;
use EasyGithDev\PHPOpenAI\Curl\Responses\ModerationResponse;
use EasyGithDev\PHPOpenAI\OpenAIApi;
use EasyGithDev\PHPOpenAI\OpenAIModel;

class Moderation extends OpenAIModel
{
    public const END_POINT = '/moderations';

    /**
     * @param  protected
     */
    public function __construct(protected OpenAIApi $client)
    {
        $this->request = new CurlRequest();
        $this->response = new ModerationResponse();
    }

    /**
     * @param string $input
     *
     * @return CurlResponse
     */
    public function create(string $input): ModerationResponse
    {
        if (empty($input)) {
            throw new \Exception("Input can not be empty");
        }

        $payload =  [
            "input" => $input,
        ];

        $response =  $this->request
            ->setBaseHeaders($this->client->getConfiguration()->getCurlHeaders())
            ->setBaseUrl($this->client->getConfiguration()->getApiUrl())
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
