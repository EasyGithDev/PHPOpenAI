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
        $this->setApiKey($apiKey);
        $this->setOrganization($organization);
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
     * Adding the api key to the headers
     * @param array $apiKey
     *
     * @return self
     */
    public function setApiKey(string $apiKey): self
    {
        if (empty($apiKey)) {
            throw new ClientException('apiKey can not be empty');
        }

        $this->addHeader("Authorization: Bearer $apiKey");

        return $this;
    }

    /**
     * Adding the organization to the headers
     * @param string $organization
     *
     * @return self
     */
    public function setOrganization(string $organization): self
    {
        if (!empty($organization)) {
            $this->addHeader("OpenAI-Organization: $organization");
        }

        return $this;
    }

    /**
     * Adding an element to the headers.
     * If the header exist, it will be replaced
     * @param string $header
     *
     * @return self
     */
    public function addHeader(string $header): self
    {
        if (($key = array_search($header, $this->headers)) !== false) {
            $this->headers[$key] = $header;
        } else {
            $this->headers[] = $header;
        }
        return $this;
    }

    /**
     * Removing an element to the headers
     * @param string $header
     *
     * @return self
     */
    public function removeHeader(string $header): self
    {
        if (($key = array_search($header, $this->headers)) !== false) {
            unset($this->headers[$key]);
        }
        return $this;
    }
}
