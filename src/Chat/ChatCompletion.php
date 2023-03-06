<?php

namespace EasyGithDev\PHPOpenAI\Chat;

use EasyGithDev\PHPOpenAI\Curl;

class ChatCompletion
{
    const API_URL = 'https://api.openai.com/v1/chat/completions';
    const MAX_PROMPT_CHARS = 1000;

    protected Curl $curl;
    protected array $headers = [
        'Content-Type: application/json',
        'Authorization: Bearer ',
    ];


    /**
     * @param string $apiKey
     */
    function __construct(string $apiKey)
    {
        $this->curl = new Curl;
        $this->headers[1] = $this->headers[1] . $apiKey;
    }


    /** 
    model
string
Required
ID of the model to use. Currently, only gpt-3.5-turbo and gpt-3.5-turbo-0301 are supported.

messages
array
Required
The messages to generate chat completions for, in the chat format.

temperature
number
Optional
Defaults to 1
What sampling temperature to use, between 0 and 2. Higher values like 0.8 will make the output more random, while lower values like 0.2 will make it more focused and deterministic.

We generally recommend altering this or top_p but not both.

top_p
number
Optional
Defaults to 1
An alternative to sampling with temperature, called nucleus sampling, where the model considers the results of the tokens with top_p probability mass. So 0.1 means only the tokens comprising the top 10% probability mass are considered.

We generally recommend altering this or temperature but not both.

n
integer
Optional
Defaults to 1
How many chat completion choices to generate for each input message.

stream
boolean
Optional
Defaults to false
If set, partial message deltas will be sent, like in ChatGPT. Tokens will be sent as data-only server-sent events as they become available, with the stream terminated by a data: [DONE] message.

stop
string or array
Optional
Defaults to null
Up to 4 sequences where the API will stop generating further tokens.

max_tokens
integer
Optional
Defaults to inf
The maximum number of tokens allowed for the generated answer. By default, the number of tokens the model can return will be (4096 - prompt tokens).

presence_penalty
number
Optional
Defaults to 0
Number between -2.0 and 2.0. Positive values penalize new tokens based on whether they appear in the text so far, increasing the model's likelihood to talk about new topics.

See more information about frequency and presence penalties.

frequency_penalty
number
Optional
Defaults to 0
Number between -2.0 and 2.0. Positive values penalize new tokens based on their existing frequency in the text so far, decreasing the model's likelihood to repeat the same line verbatim.

See more information about frequency and presence penalties.

logit_bias
map
Optional
Defaults to null
Modify the likelihood of specified tokens appearing in the completion.

Accepts a json object that maps tokens (specified by their token ID in the tokenizer) to an associated bias value from -100 to 100. Mathematically, the bias is added to the logits generated by the model prior to sampling. The exact effect will vary per model, but values between -1 and 1 should decrease or increase likelihood of selection; values like -100 or 100 should result in a ban or exclusive selection of the relevant token.

user
string
Optional
A unique identifier representing your end-user, which can help OpenAI to monitor and detect abuse. Learn more.

     */

    function create(
        Model $model,
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
    ): string {

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

        // var_dump($msg);die;
        $response =  $this->curl
            ->setUrl(self::API_URL)
            ->setHeaders(
                $this->headers
            )
            ->setPayload(
                [
                    "model" => $model->value,
                    "messages" => $msg,
                    "temperature" => $temperature,
                    "top_p" => $top_p,
                    "n" => $n,
                    "stream" => $stream,
                    "max_tokens" => $max_tokens,
                    "presence_penalty" => $presence_penalty,
                    "frequency_penalty" => $frequency_penalty
                ]
            )
            ->exec();

        $this->curl->close();

        return $response;
    }
}