<?php

namespace EasyGithDev\PHPOpenAI\Handlers;

use EasyGithDev\PHPOpenAI\Exceptions\ClientException;
use EasyGithDev\PHPOpenAI\OpenAIClient;
use EasyGithDev\PHPOpenAI\OpenAIHandler;

class FineTune extends OpenAIHandler
{
    public const END_POINT = '/fine-tunes';

    use Stream;

    /**
     * @param  protected
     */
    public function __construct(protected OpenAIClient $client)
    {
    }

    /**
     * @return self
     */
    public function list(): self
    {
        $this->request = $this->client->get(
            self::END_POINT
        );

        return $this;
    }

    /**
     * @param string $fine_tune_id
     * @param bool $stream
     *
     * @return self
     */
    public function listEvents(string $fine_tune_id, bool $stream = false): self
    {
        $params = [];
        if ($stream) {
            $params['callback'] = $this->getCallback();
            $params['stream'] = $stream;
        }

        $this->request = $this->client->get(
            self::END_POINT . '/' . $fine_tune_id . '/events',
            params: $params
        );

        return $this;
    }

    /**
     * @param string $training_file
     * @param string $purpose
     *
     * @return self
     */
    public function create(
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
    ): self {
        $payload =  [
            "training_file" => $training_file,
            "n_epochs" => $n_epochs,
            "compute_classification_metrics" => $compute_classification_metrics,
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

        $this->request = $this->client->post(
            self::END_POINT,
            json_encode($payload),
            ['Content-Type: application/json']
        );

        return $this;
    }


    /**
     * @param string $fine_tune_id
     *
     * @return self
     */
    public function retrieve(string $fine_tune_id): self
    {
        if (empty($fine_tune_id)) {
            throw new ClientException("fine_tune_id can not be empty");
        }

        $this->request = $this->client->get(
            self::END_POINT . '/' . $fine_tune_id
        );

        return $this;
    }

    /**
     * @param string $fine_tune_id
     *
     * @return self
     */
    public function cancel(string $fine_tune_id): self
    {
        if (empty($fine_tune_id)) {
            throw new ClientException("fine_tune_id can not be empty");
        }

        $this->request = $this->client->post(
            self::END_POINT . '/' . $fine_tune_id . '/cancel'
        );

        return $this;
    }
}
