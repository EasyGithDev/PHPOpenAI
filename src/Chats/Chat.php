<?php

namespace EasyGithDev\PHPOpenAI\Chats;

use EasyGithDev\PHPOpenAI\Curl\CurlRequest;
use EasyGithDev\PHPOpenAI\Models\ModelEnum;
use EasyGithDev\PHPOpenAI\Curl\CurlResponse;
use EasyGithDev\PHPOpenAI\Curl\Responses\ChatResponse;

class Chat
{
    const MAX_PROMPT_CHARS = 1000;
    const END_POINT = '/chat/completions';




    /**
     * @param string $apiUrl
     * @param array $headers
     */
    function __construct(protected CurlRequest $curl, protected CurlResponse $response)
    {
    }


    function create(
        ModelEnum $model,
        array $messages,
        float $temperature = 1.0,
        float $top_p = 1.0,
        int $n = 1,
        bool $stream = false,
        string|array|null $stop = null,
        int $max_tokens = 128,
        int $presence_penalty = 0,
        int $frequency_penalty = 0,
        $logit_bias = null,
        string $user = ''
    ): ChatResponse {

        if ($temperature < 0 or $temperature > 2) {
            throw new \Exception("Temperature to use, between 0 and 2");
        }

        if ($top_p < 0 or $top_p > 2) {
            throw new \Exception("Nucleus sampling to use, between 0 and 2");
        }

        if ($n < 1 or $n > 10) {
            throw new \Exception('$n is between 1 and 10');
        }

        if ($presence_penalty < -2 or $presence_penalty > 2) {
            throw new \Exception("Presence_penalty is a number between -2.0 and 2.0");
        }

        if ($frequency_penalty < -2 or $frequency_penalty > 2) {
            throw new \Exception("Frequency_penalty is a number between -2.0 and 2.0");
        }

        $msg = [];
        foreach ($messages as $message) {
            $msg[] =  $message->toArray();
        }

        $payload =       [
            "model" => $model->value,
            "messages" => $msg,
            "temperature" => $temperature,
            "top_p" => $top_p,
            "n" => $n,
            "stream" => $stream,
            "max_tokens" => $max_tokens,
            "presence_penalty" => $presence_penalty,
            "frequency_penalty" => $frequency_penalty
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
