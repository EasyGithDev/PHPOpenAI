<?php

namespace EasyGithDev\PHPOpenAI\Handlers;

use EasyGithDev\PHPOpenAI\Exceptions\ClientException;
use EasyGithDev\PHPOpenAI\Helpers\ModelEnum;
use EasyGithDev\PHPOpenAI\OpenAIClient;
use EasyGithDev\PHPOpenAI\OpenAIHandler;

class Edit extends OpenAIHandler
{
    public const END_POINT = '/edits';

    
    /**
     * @param  protected
     */
    public function __construct(protected OpenAIClient $client)
    {
    }

    public function create(
        string $instruction,
        ModelEnum|string $model,
        string $input = '',
        float $temperature = 1.0,
        float $top_p = 1.0,
        int $n = 1,
    ): self {
        if (empty($model)) {
            throw new ClientException("Input is required");
        }

        if (empty($instruction)) {
            throw new ClientException("Instruction can not be empty");
        }

        if ($temperature < 0 or $temperature > 2) {
            throw new ClientException("Temperature to use, between 0 and 2");
        }

        if ($top_p < 0 or $top_p > 2) {
            throw new ClientException("Nucleus sampling to use, between 0 and 2");
        }

        if ($n < 1 or $n > 10) {
            throw new ClientException('$n is between 1 and 10');
        }

        $payload =  [
            "instruction" => $instruction,
            "model" => is_string($model) ? $model : $model->value,
            "input" => $input,
            "temperature" => $temperature,
            "top_p" => $top_p,
            "n" => $n,
        ];

        $this->request = $this->client->post(
            self::END_POINT,
            json_encode($payload),
            ['Content-Type: application/json']
        );

        return $this;
    }
}
