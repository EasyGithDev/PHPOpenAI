<?php

namespace EasyGithDev\PHPOpenAI\Handlers;

use EasyGithDev\PHPOpenAI\Exceptions\ClientException;
use EasyGithDev\PHPOpenAI\Helpers\ContentTypeEnum;
use EasyGithDev\PHPOpenAI\OpenAIClient;
use EasyGithDev\PHPOpenAI\OpenAIHandler;

/**
 * [Description Moderation]
 */
class Moderation extends OpenAIHandler
{
    /**
     * @param  protected
     */
    public function __construct(protected OpenAIClient $client)
    {
    }

    /**
     * @param string $input
     *
     * @return self
     */
    public function create(string $input): self
    {
        if (empty($input)) {
            throw new ClientException("Input can not be empty");
        }

        $payload =  [
            "input" => $input,
        ];

        $this->setRequest($this->client->post(
            $this->client->getRoute()->moderationCreate(),
            json_encode($payload),
            ContentTypeEnum::JSON->toHeaderArray()
        ));

        return $this;
    }
}
