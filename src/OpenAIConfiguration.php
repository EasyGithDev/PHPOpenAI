<?php

namespace EasyGithDev\PHPOpenAI;

use EasyGithDev\PHPOpenAI\Exceptions\ClientException;

/**
 * [Description OpenAIConfiguration]
 */
class OpenAIConfiguration
{
    /**
     * @var string
     */
    protected string $apiUrl = 'https://api.openai.com/v1';

    /**
     * @var array
     */
    protected array $headers = [];

    /**
     * @param string $apiKey
     * @param string $organization
     */
    public function __construct(string $apiKey, string $organization = '')
    {
        if (empty($apiKey)) {
            throw new ClientException('apiKey can not be empty');
        }

        $this->addHeader("Authorization: Bearer $apiKey");

        if (!empty($organization)) {
            $this->addHeader("OpenAI-Organization: $organization");
        }
    }

    /**
     * @param string $apiKey
     * @param string $organization
     *
     * @return OpenAIConfiguration
     */
    public static function Configuration(string $apiKey, string $organization = ''): OpenAIConfiguration
    {
        return new OpenAIConfiguration($apiKey, $organization);
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

    /**
     * @param string $header
     *
     * @return self
     */
    public function addHeader(string $header): self
    {
        $this->headers[] = $header;
        return $this;
    }
}
