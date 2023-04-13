<?php

namespace EasyGithDev\PHPOpenAI\Handlers;

use EasyGithDev\PHPOpenAI\Curl\CurlBuilder;
use EasyGithDev\PHPOpenAI\Exceptions\ClientException;
use EasyGithDev\PHPOpenAI\Helpers\ContentTypeEnum;
use EasyGithDev\PHPOpenAI\Helpers\ImageResponseEnum;
use EasyGithDev\PHPOpenAI\Helpers\ImageSizeEnum;
use EasyGithDev\PHPOpenAI\OpenAIClient;
use EasyGithDev\PHPOpenAI\OpenAIHandler;

/**
 * [Description Image]
 */
class Image extends OpenAIHandler
{
    public const MAX_PROMPT_CHARS = 1000;

    /**
     * @param  protected
     */
    public function __construct(protected OpenAIClient $client)
    {
    }


    /**
     * @param string $prompt
     * @param int $n
     * @param ImageSizeEnum|string $size
     * @param ImageResponseEnum|string $response_format
     * @param string $user
     *
     * @return self
     */
    public function create(string $prompt, int $n = 1, ImageSizeEnum|string $size = ImageSizeEnum::is1024, ImageResponseEnum|string $response_format = ImageResponseEnum::URL, string $user = ''): self
    {
        if (mb_strlen($prompt) > self::MAX_PROMPT_CHARS) {
            throw new ClientException("Max prompt is 1000 chars");
        }

        if ($n < 1 or $n > 10) {
            throw new ClientException('$n is between 1 and 10');
        }

        $payload = [
            "prompt" => $prompt,
            "n" => $n,
            "size" => is_string($size) ? $size : $size->value,
            "response_format" => is_string($response_format) ? $response_format : $response_format->value,
        ];

        if (!empty($user)) {
            $payload["user"] = $user;
        }

        $this->setRequest(CurlBuilder::post(
            $this->client->getRoute()->imageCreate(),
            json_encode($payload),
            array_merge(
                $this->client->getConfiguration()->getHeaders(),
                ContentTypeEnum::JSON->toHeaderArray()
            ),
            ['timeout' => 60]
        ));

        return $this;
    }

    /**
     * @param string $image
     * @param int $n
     * @param ImageSizeEnum|string $size
     * @param ImageResponseEnum|string $response_format
     * @param string $user
     *
     * @return self
     */
    public function createVariation(string $image, int $n = 1, ImageSizeEnum|string $size = ImageSizeEnum::is1024, ImageResponseEnum|string $response_format = ImageResponseEnum::URL, string $user = ''): self
    {
        if (!file_exists($image)) {
            throw new ClientException("Unable to locate file: $image");
        }

        $payload = [
            "image" => curl_file_create($image),
            "n" => $n,
            "size" => is_string($size) ? $size : $size->value,
            "response_format" => is_string($response_format) ? $response_format : $response_format->value,
        ];

        if (!empty($user)) {
            $payload["user"] = $user;
        }

        $this->setRequest(CurlBuilder::post(
            $this->client->getRoute()->imageCreateVariation(),
            $payload,
            $this->client->getConfiguration()->getHeaders(),
            ['timeout' => 60]
        ));

        return $this;
    }

    /**
     * @param string $image
     * @param string $prompt
     * @param string $mask
     * @param int $n
     * @param ImageSizeEnum|string $size
     * @param ImageResponseEnum|string $response_format
     * @param string $user
     *
     * @return self
     */
    public function createEdit(string $image, string $prompt, string $mask = '', int $n = 1, ImageSizeEnum|string $size = ImageSizeEnum::is1024, ImageResponseEnum|string $response_format = ImageResponseEnum::URL, string $user = ''): self
    {
        if (!file_exists($image)) {
            throw new ClientException("Unable to locate file: $image");
        }

        if (!empty($mask) && !file_exists($mask)) {
            throw new ClientException("Unable to locate mask: $mask");
        }

        if (mb_strlen($prompt) > 1000) {
            throw new ClientException("Prompt max char is : 1000");
        }

        if ($n < 1 or $n > 10) {
            throw new ClientException('$n is between 1 and 10');
        }

        $payload = [
            "image" => curl_file_create($image),
            "prompt" => $prompt,
            "n" => $n,
            "size" => is_string($size) ? $size : $size->value,
            "response_format" => is_string($response_format) ? $response_format : $response_format->value,
        ];

        if (!empty($mask)) {
            $payload["mask"] = curl_file_create($mask);
        }

        if (!empty($user)) {
            $payload["user"] = $user;
        }

        $this->setRequest(CurlBuilder::post(
            $this->client->getRoute()->imageCreateEdit(),
            $payload,
            $this->client->getConfiguration()->getHeaders(),
            ['timeout' => 60]
        ));

        return $this;
    }
}
