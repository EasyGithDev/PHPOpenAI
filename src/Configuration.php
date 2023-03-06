<?php

namespace EasyGithDev\PHPOpenAI;

class Configuration
{
    protected array $headers = [
        'Content-Type: application/json',
        'Authorization: Bearer ',
        'OpenAI-Organization: ',
    ];

    public function __construct(
        protected string $apiKey,
        protected string $organization = ''
    ) {

        $this->headers[1] = $this->headers[1] . $this->apiKey;

        if (empty($organization)) {
            unset($this->headers[2]);
        } else {
            $this->headers[2] = $this->headers[2] . $this->organization;
        }
    }

    public function toArray(): array
    {
        return $this->headers;
    }
}
