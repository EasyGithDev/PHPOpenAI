<?php

namespace EasyGithDev\PHPOpenAI;

use EasyGithDev\PHPOpenAI\Contracts\HeaderInterface;
use EasyGithDev\PHPOpenAI\Exceptions\ClientException;

/**
 * The OpenAIConfiguration class is responsible
 * for constructing the necessary HTTP headers for making requests to the OpenAI API.
 *
 * It has a constructor that takes two parameters: the apiKey and the optional organization.
 * The apiKey is required and if empty, it throws a ClientException.
 *
 * It adds an "Authorization" header with the apiKey value using the "Bearer" scheme.
 *
 * If an organization is provided, it also adds an "OpenAI-Organization" header with the organization value.
 */
class OpenAIConfiguration implements HeaderInterface
{
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
