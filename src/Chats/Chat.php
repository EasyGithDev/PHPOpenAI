<?php

namespace EasyGithDev\PHPOpenAI\Chats;

use EasyGithDev\PHPOpenAI\Curl\CurlRequest;
use EasyGithDev\PHPOpenAI\Models\ModelEnum;
use EasyGithDev\PHPOpenAI\Curl\CurlResponse;
use EasyGithDev\PHPOpenAI\Curl\Responses\ChatResponse;

class Chat
{
    const END_POINT = '/chat/completions';
    const MAX_PROMPT_CHARS = 1000;
    const MAX_TOKENS = 4096;
    const MAX_LOGPROBS = 5;
    const MAX_TOP_P = 1;
    const MIN_TOP_P = 0;
    const MAX_TEMPERATURE = 1;
    const MIN_TEMPERATURE = 0;
    const MAX_N = 10;
    const MIN_N = 0;
    const MAX_PRESENCE_PENALITY = 2.0;
    const MIN_PRESENCE_PENALITY = -2.0;
    const MAX_FRENQUENCY_PENALITY = 2.0;
    const MIN_FRENQUENCY_PENALITY = -2.0;



    /**
     * @param string $apiUrl
     * @param array $headers
     */
    function __construct(protected CurlRequest $curl, protected CurlResponse $response)
    {
    }


    function create(
        ModelEnum|string $model,
        array $messages,
        float $temperature = 1.0,
        float $top_p = 1.0,
        int $n = 1,
        bool $stream = false,
        string|array|null $stop = null,
        int $max_tokens = 128,
        int $presence_penalty = 0,
        int $frequency_penalty = 0,
        ?array $logit_bias = null,
        string $user = ''
    ): ChatResponse {

        if (empty($model)) {
            throw new \Exception("Model can not be empty");
        }

        if (!count($messages)) {
            throw new \Exception("Messages can not be empty");
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

        if ($presence_penalty < self::MIN_PRESENCE_PENALITY or $presence_penalty > self::MAX_PRESENCE_PENALITY) {
            throw new \Exception("Presence_penalty is a number between 0 and 2.0");
        }

        if ($frequency_penalty < self::MIN_FRENQUENCY_PENALITY or $frequency_penalty > self::MAX_FRENQUENCY_PENALITY) {
            throw new \Exception("Frequency_penalty is a number between 0 and 2.0");
        }

        $msg = array_map(function ($message) {
            return $message->toArray();
        }, $messages);

        $payload =       [
            "model" => is_string($model) ? $model : $model->value,
            "messages" => $msg,
            "temperature" => $temperature,
            "max_tokens" => $max_tokens,
            "presence_penalty" => $presence_penalty,
            "frequency_penalty" => $frequency_penalty
        ];

        if ($top_p < 1) {
            $payload["top_p"] = $top_p;
        }

        if ($n > 1) {
            $payload["n"] = $n;
        }

        if ($stream) {
            $payload["stream"] = $stream;
        }

        if (!is_null($stop)) {
            $payload["stop"] = is_array($stop) ? $stop : [$stop];
        }

        if (!is_null($logit_bias)) {
            $payload["logit_bias"] =  $logit_bias;
        }

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
