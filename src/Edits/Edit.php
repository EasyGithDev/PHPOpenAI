<?php

namespace EasyGithDev\PHPOpenAI\Edits;

use EasyGithDev\PHPOpenAI\Curl\CurlRequest;
use EasyGithDev\PHPOpenAI\Models\ModelEnum;
use EasyGithDev\PHPOpenAI\Curl\CurlResponse;


class Edit
{
    const END_POINT = '/edits';

    


    /**
     * @param string $apiUrl
     * @param array $headers
     */
    function __construct(protected CurlRequest $curl, protected CurlResponse $response)
    {
        
       
    }

    function create(
        string $instruction,
        ModelEnum $model = ModelEnum::TEXT_DAVINCI_EDIT_001,
        string $input = '',
        float $temperature = 1.0,
        float $top_p = 1.0,
        int $n = 1,
    ): CurlResponse {

        if (empty($instruction)) {
            throw new \Exception("Instruction can not be empty");
        }
        
        if ($model != ModelEnum::TEXT_DAVINCI_EDIT_001 && $model != ModelEnum::CODE_DAVINCI_EDIT_001) {
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
            ->appendToUrl( self::END_POINT)
            ->setPayload(
                json_encode($payload)
            )
            ->exec();

        $this->curl->close();

                return $this->response->setInfos($response);
    }
}
