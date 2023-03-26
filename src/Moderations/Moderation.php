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
    public function __construct(protected ?OpenAIApi $client = null)
    {
    }

    /**
     * @param string $input
     *
     * @return CurlResponse
     */
    public function create(string $input): self
    {
        if (empty($input)) {
            throw new \Exception("Input can not be empty");
        }

        $payload =  [
            "input" => $input,
        ];

        $this->request = $this->client->post(
            self::END_POINT,
            json_encode($payload),
            ['Content-Type: application/json']
        );

        return $this;
    }
}
