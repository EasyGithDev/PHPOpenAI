<?php

namespace EasyGithDev\PHPOpenAI;

use Exception;

class OpenAIConfiguration
{
    protected string $apiUrl = 'https://api.openai.com/v1';
    protected array $headers = [];

    public function __construct(
        string $apiKey,
        string $organization = ''
    ) {
        if (empty($apiKey)) {
            throw new Exception('apiKey can not be empty');
        }

        $this->addHeader("Authorization: Bearer $apiKey");

        if (!empty($organization)) {
            $this->addHeader("OpenAI-Organization: $organization");
        }
    }

    public static function defaultConfiguration(string $apiKey): OpenAIConfiguration
    {
        return new OpenAIConfiguration($apiKey);
    }

    public function addHeader(string $header): self
    {
        $this->headers[] = $header;
        return $this;
    }

    /**
     * Get the value of apiUrl
     */
    public function getApiUrl(): string
    {
        return $this->apiUrl;
    }

    /**
     * Set the value of apiUrl
     *
     * @return  self
     */
    public function setApiUrl($apiUrl): self
    {
        $this->apiUrl = $apiUrl;

        return $this;
    }

    /**
     * Get the value of headers
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Set the value of headers
     *
     * @return  self
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;

        return $this;
    }
}
