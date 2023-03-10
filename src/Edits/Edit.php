<?php

namespace EasyGithDev\PHPOpenAI\Edits;

use EasyGithDev\PHPOpenAI\Curl;
use EasyGithDev\PHPOpenAI\Model;

class Edit
{
    const END_POINT = '/edits';

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
        string $instruction,
        Model $model = Model::TEXT_DAVINCI_EDIT_001,
        string $input = '',
        float $temperature = 1.0,
        float $top_p = 1.0,
        int $n = 1,
    ): string {

        if (empty($instruction)) {
            throw new \Exception("Instruction can not be empty");
        }
        
        if ($model != Model::TEXT_DAVINCI_EDIT_001 && $model != Model::CODE_DAVINCI_EDIT_001) {
            throw new \Exception("text-davinci-edit-001 or code-davinci-edit-001 are supported");
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
            "model" => $model->value,
            "input" => $input,
            "temperature" => $temperature,
            "top_p" => $top_p,
            "n" => $n,
        ];

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
