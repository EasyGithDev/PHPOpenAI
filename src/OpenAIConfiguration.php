<?php

namespace EasyGithDev\PHPOpenAI;

use Exception;

class OpenAIConfiguration
{
    public static $_configDir = __DIR__ . '/../config';
    protected string $apiUrl = 'https://api.openai.com/v1';
    protected array $headers = [];

    public function __construct(
        string $apiKey,
        string $organization = ''
    ) {
        if (empty($apiKey)) {
            throw new Exception('apiKey can not be empty');
        }

        $this->setHeader(['Authorization' => "Bearer $apiKey"]);

        if (!empty($organization)) {
            $this->setHeader(['OpenAI-Organization' => $organization]);
        }
    }

    public function setHeader(array $header): self
    {
        $this->headers[] = $header;
        return $this;
    }

    public function getCurlHeaders(?array $additionalHeader = null): array
    {
        $headers = $this->headers;

        if (!is_null($additionalHeader)) {
            $headers = array_merge($headers, $additionalHeader);
        }

        return array_map(function (array $value): string {
            $k = array_key_first($value);
            return $k . ': ' . $value[$k];
        }, $headers);
    }

    public static function defaultConfiguration(string $apiKey): OpenAIConfiguration
    {
        return new OpenAIConfiguration($apiKey);
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
}