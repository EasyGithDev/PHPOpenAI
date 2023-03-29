<?php

namespace EasyGithDev\PHPOpenAI\Handlers;

use EasyGithDev\PHPOpenAI\Helpers\ModelEnum;
use EasyGithDev\PHPOpenAI\OpenAIClient;
use EasyGithDev\PHPOpenAI\OpenAIHandler;

class Completion extends OpenAIHandler
{
    public const END_POINT = '/completions';
    public const MAX_TOKENS = 4096;
    public const MAX_LOGPROBS = 5;
    public const MAX_TOP_P = 1;
    public const MIN_TOP_P = 0;
    public const MAX_TEMPERATURE = 1;
    public const MIN_TEMPERATURE = 0;
    public const MAX_N = 10;
    public const MIN_N = 0;
    public const MAX_PRESENCE_PENALITY = 2.0;
    public const MIN_PRESENCE_PENALITY = -2.0;
    public const MAX_FRENQUENCY_PENALITY = 2.0;
    public const MIN_FRENQUENCY_PENALITY = -2.0;

    /**
     * @param  protected
     */
    public function __construct(protected ?OpenAIClient $client = null)
    {
    }

    public function create(
        ModelEnum|string $model,
        string $prompt,
        ?string $suffix = null,
        int $max_tokens = 16,
        float $temperature = 1.0,
        float $top_p = 1.0,
        int $n = 1,
        bool $stream = false,
        ?int $logprobs = null,
        bool $echo  = false,
        string|array|null $stop = null,
        float $presence_penalty = 0.0,
        float $frequency_penalty = 0.0,
        int $best_of = 1,
        ?array $logit_bias = null,
        string $user = ''
    ): self {
        if (empty($model)) {
            throw new \Exception("Model can not be empty");
        }

        if (empty($prompt)) {
            throw new \Exception("Prompt can not be empty");
        }

        if ($max_tokens > self::MAX_TOKENS) {
            throw new \Exception("Max tokens are " . self::MAX_TOKENS);
        }

        if ($temperature < self::MIN_TEMPERATURE or $temperature > self::MAX_TEMPERATURE) {
            throw new \Exception("Temperature to use, between 0 and 1");
        }

        if ($top_p < self::MIN_TOP_P or $top_p > self::MAX_TOP_P) {
            throw new \Exception("Nucleus sampling to use, between 0 and 1");
        }

        if ($n < self::MIN_N or $n > self::MAX_N) {
            throw new \Exception('$n is between 1 and 10');
        }

        if ($logprobs > self::MAX_LOGPROBS) {
            throw new \Exception('Maximum for logprobs is 5');
        }

        if ($presence_penalty < self::MIN_PRESENCE_PENALITY or $presence_penalty > self::MAX_PRESENCE_PENALITY) {
            throw new \Exception("Presence_penalty is a number between 0 and 2.0");
        }

        if ($frequency_penalty < self::MIN_FRENQUENCY_PENALITY or $frequency_penalty > self::MAX_FRENQUENCY_PENALITY) {
            throw new \Exception("Frequency_penalty is a number between 0 and 2.0");
        }

        $payload =  [
            "model" => is_string($model) ? $model : $model->value,
            "prompt" => $prompt,
            "temperature" => $temperature,
            "top_p" => $top_p,
            "max_tokens" => $max_tokens,
            "presence_penalty" => $presence_penalty,
            "frequency_penalty" => $frequency_penalty,
        ];

        if (!is_null($suffix)) {
            $payload["suffix"] = $suffix;
        }

        // if ($top_p < 1) {
        //     $payload["top_p"] = $top_p;
        // }

        if ($n > 1) {
            $payload["n"] = $n;
        }

        if ($stream) {
            $payload["stream"] = $stream;
        }

        if (!is_null($logprobs)) {
            $payload["logprobs"] =  $logprobs;
        }

        if ($echo) {
            $payload["echo"] = $echo;
        }

        if (!is_null($stop)) {
            $payload["stop"] = is_array($stop) ? $stop : [$stop];
        }

        if ($best_of > 1) {
            $payload["best_of"] = $best_of;
        }

        if (!is_null($logit_bias)) {
            $payload["logit_bias"] =  $logit_bias;
        }

        if (!empty($user)) {
            $payload["user"] = $user;
        }

        $this->request = (!$stream) ? $this->client->post(
            self::END_POINT,
            json_encode($payload),
            ['Content-Type: application/json']
        ) : $this->client->stream(
            self::END_POINT,
            json_encode($payload),
            ['Content-Type: application/json']
        );

        return $this;
    }
}