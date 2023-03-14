<?php

namespace EasyGithDev\PHPOpenAI;

class Configuration
{
    static $_configDir = __DIR__ . '/../config';

    protected array $headers = [
        'Content-Type' => '',
        'Authorization' => '',
        'OpenAI-Organization' => '',
    ];

    public function __construct(
        string $apiKey,
        string $organization = '',
        string $contentType = ''
    ) {

        $this->headers['Authorization'] = "Bearer $apiKey";

        if (!empty($organization)) {
            $this->headers['OpenAI-Organization'] = $organization;
        }

        if (!empty($contentType)) {
            $this->headers['Content-Type'] = $contentType;
        }
    }

    public function setContentType(string $contentType): self
    {
        $this->headers['Content-Type'] = $contentType;
        return $this;
    }

    public function setApplicationJson(): self
    {
        return $this->setContentType('application/json');
    }

    public function toArray(): array
    {
        $headers = [];
        foreach ($this->headers as $k => $v) {
            if (empty($v)) {
                continue;
            }
            $headers[] = "$k: $v";
        }
        return $headers;
    }

    public static function defaultConfiguration(string $apiKey): Configuration
    {
        return new Configuration($apiKey);
    }
}
