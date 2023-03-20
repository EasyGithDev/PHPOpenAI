<?php

namespace EasyGithDev\PHPOpenAI\Finetunes;

use EasyGithDev\PHPOpenAI\Curl\CurlRequest;
use EasyGithDev\PHPOpenAI\Curl\CurlResponse;
use Exception;

class FineTune
{
    const END_POINT = '/fine-tunes';

    /**
     * @param string $apiUrl
     * @param array $headers
     */
    function __construct(protected CurlRequest $curl, protected CurlResponse $response)
    {
    }

    /**
     * @return CurlResponse
     */
    function list(): CurlResponse
    {
        $response =  $this->curl
            ->appendToUrl(self::END_POINT)
            ->exec();

        $this->curl->close();

        return $this->response->setInfos($response);
    }

    function listEvents(string $fine_tune_id, bool $stream = false): CurlResponse
    {
        $response =  $this->curl
            ->appendToUrl(self::END_POINT . '/' . $fine_tune_id . '/events')
            ->exec();

        $this->curl->close();

        return $this->response->setInfos($response);
    }

    /**
     * @param string $training_file
     * @param string $purpose
     * 
     * @return CurlResponse
     */
    function create(
        string $training_file,
        string $validation_file = '',
        string $model = '',
        int $n_epochs = 4,
        ?int $batch_size = null,
        ?int $learning_rate_multiplier = null,
        bool $compute_classification_metrics = false,
        ?int $classification_n_classes = null,
        ?string $classification_positive_class = null,
        ?array $classification_betas = null,
        ?string $suffix = null
    ): CurlResponse {

        $payload =  [
            "training_file" => $training_file,
            // "n_epochs" => $n_epochs,
            // "compute_classification_metrics" => $compute_classification_metrics,
        ];

        if (!empty($validation_file)) {
            $payload['validation_file'] = $validation_file;
        }

        if (!empty($model)) {
            $payload['model'] = $model;
        }

        if (!is_null($batch_size)) {
            $payload['batch_size'] = $batch_size;
        }

        if (!is_null($learning_rate_multiplier)) {
            $payload['learning_rate_multiplier'] = $learning_rate_multiplier;
        }

        if (!is_null($classification_n_classes)) {
            $payload['classification_n_classes'] = $classification_n_classes;
        }

        if (!is_null($classification_positive_class)) {
            $payload['classification_positive_class'] = $classification_positive_class;
        }

        if (!is_null($classification_betas)) {
            $payload['classification_betas'] = $classification_betas;
        }

        if (!is_null($suffix)) {
            $payload['suffix'] = $suffix;
        }
        $response =  $this->curl
            ->appendToUrl(self::END_POINT)
            ->setPayload(
                $payload
            )
            ->addHeaders(['Content-Type: application/json'])
            // ->verboseEnabled('debug.txt')
            ->exec();

        $this->curl->close();

        return $this->response->setInfos($response);
    }

    /**
     * @param string $fine_tune_id
     * 
     * @return CurlResponse
     */
    function retrieve(string $fine_tune_id): CurlResponse
    {

        if (empty($fine_tune_id)) {
            throw new Exception("fine_tune_id can not be empty");
        }

        $response =  $this->curl
            ->appendToUrl(self::END_POINT . '/' . $fine_tune_id)
            ->exec();

        $this->curl->close();

        return $this->response->setInfos($response);
    }

    function cancel(string $fine_tune_id): CurlResponse
    {
        if (empty($fine_tune_id)) {
            throw new Exception("fine_tune_id can not be empty");
        }

        $response =  $this->curl
            ->appendToUrl(self::END_POINT . '/' . $fine_tune_id . '/cancel')
            ->setMethod(CurlRequest::CURL_POST)
            ->exec();

        $this->curl->close();

        return $this->response->setInfos($response);
    }
}
