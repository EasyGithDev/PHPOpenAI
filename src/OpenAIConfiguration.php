<?php

namespace EasyGithDev\PHPOpenAI;

use EasyGithDev\PHPOpenAI\Contracts\HeaderInterface;
use EasyGithDev\PHPOpenAI\Exceptions\ClientException;

/**
 * [Description OpenAIConfiguration]
 */
class OpenAIConfiguration implements HeaderInterface
{
    /**
     * Depreciate
     * The API url
     * @var string
     */
    protected string $apiUrl = 'https://api.openai.com/v1';

    /**
     * The HTTP headers
     * @var array
     */
    protected array $headers = [];

    /**
     * Build the configuration headers needed by the api
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
     * Build the configuration headers needed by the api
     *
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
     * Depreciate
     * Get the value of apiUrl
     * @return string
     */
    public function getApiUrl(): string
    {
        return $this->apiUrl;
    }

    /**
     * Depreciate
     * Set the value of apiUrl
     *
     * @param string $apiUrl
     *
     * @return self
     */
    public function setApiUrl(string $apiUrl): self
    {
        $this->apiUrl = $apiUrl;

        return $this;
    }

    /**
     * Get the value of headers
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Set the value of headers
     *
     * @param array $headers
     *
     * @return self
     */
    public function setHeaders(array $headers): self
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * Adding an element to the headers
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
