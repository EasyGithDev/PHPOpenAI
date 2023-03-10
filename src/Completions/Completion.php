<?php

namespace EasyGithDev\PHPOpenAI\Completions;

use EasyGithDev\PHPOpenAI\Curl;
use EasyGithDev\PHPOpenAI\Model;

class Completion
{
    const END_POINT = '/completions';

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
        Model $model,
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
        ?int $best_of = 1,
        $logit_bias = null,
        string $user = ''
    ): string {

        if (empty($model)) {
            throw new \Exception("Model can not be empty");
        }

        if (empty($prompt)) {
            throw new \Exception("Prompt can not be empty");
        }

        if ($temperature < 0 or $temperature > 1) {
            throw new \Exception("Temperature to use, between 0 and 1");
        }

        if ($top_p < 0 or $top_p > 1) {
            throw new \Exception("Nucleus sampling to use, between 0 and 1");
        }

        if ($n < 1 or $n > 10) {
            throw new \Exception('$n is between 1 and 10');
        }

        if ($logprobs > 5) {
            throw new \Exception('Maximum for logprobs is 5');
        }

        if ($presence_penalty < 0 or $presence_penalty > 2) {
            throw new \Exception("Presence_penalty is a number between 0 and 2.0");
        }

        if ($frequency_penalty < 0 or $frequency_penalty > 2) {
            throw new \Exception("Frequency_penalty is a number between 0 and 2.0");
        }

        $payload =  [
            "model" => $model->value,
            "prompt" => $prompt,
            "suffix" => $suffix,
            "max_tokens" => $max_tokens,
            "temperature" => $temperature,
            "top_p" => $top_p,
            "n" => $n,
            "stream" => $stream,
            "logprobs" => $logprobs,
            "echo" => $echo,
            "presence_penalty" => $presence_penalty,
            "frequency_penalty" => $frequency_penalty,
            // "logit_bias" => $logit_bias,
        ];

        if(!is_null($stop)) {
            $payload["stop"] = is_array( $stop ) ? $stop : [$stop];
        }

        if(!is_null($best_of)) {
            $payload["best_of"] = $best_of;
        }

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
