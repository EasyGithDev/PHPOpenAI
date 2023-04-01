<?php

namespace EasyGithDev\PHPOpenAI\Handlers;

use EasyGithDev\PHPOpenAI\Exceptions\ClientException;
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
    public const END_POINT = '/images';
    public const GENERATION_END_POINT = self::END_POINT . '/generations';
    public const VARIATION_END_POINT = self::END_POINT . '/variations';
    public const EDIT_END_POINT = self::END_POINT . '/edits';

    /**
     * @param  protected
     */
    public function __construct(protected OpenAIClient $client)
    {
    }

    /**
     * @param string $prompt
     * @param int $n
     * @param ImageSizeEnum $size
     * @param ImageResponseEnum $response_format
     * @param string $user
     *
     * @return self
     */
    public function create(string $prompt, int $n = 1, ImageSizeEnum $size = ImageSizeEnum::is1024, ImageResponseEnum $response_format = ImageResponseEnum::URL, string $user = ''): self
    {
        if (mb_strlen($prompt) > self::MAX_PROMPT_CHARS) {
            throw new ClientException("Max prompt is 1000 chars");
        }

        if ($n < 1 or $n > 10) {
            throw new ClientException('$n is between 1 and 10');
        }

        $payload = [
            "prompt" => "$prompt",
            "n" => $n,
            "size" => $size,
            "response_format" => $response_format,
        ];

        if (!empty($user)) {
            $payload["user"] = $user;
        }

        $this->request = $this->client->post(
            self::GENERATION_END_POINT,
            json_encode($payload),
            ['Content-Type: application/json'],
            ['timeout' => 60]
        );

        return $this;
    }



    /**
     * @param string $image
     * @param int $n
     * @param ImageSizeEnum $size
     * @param ImageResponseEnum $response_format
     * @param string $user
     *
     * @return self
     */
    public function createVariation(string $image, int $n = 1, ImageSizeEnum $size = ImageSizeEnum::is1024, ImageResponseEnum $response_format = ImageResponseEnum::URL, string $user = ''): self
    {
        if (!file_exists($image)) {
            throw new ClientException("Unable to locate file: $image");
        }

        $payload = [
            "image" => curl_file_create($image),
            "n" => $n,
            "size" => $size->value,
            "response_format" => $response_format->value,
        ];

        if (!empty($user)) {
            $payload["user"] = $user;
        }

        $this->request = $this->client->post(
            self::VARIATION_END_POINT,
            $payload,
            params: ['timeout' => 60]
        );

        return $this;
    }



    /**
     * @param string $image
     * @param string $prompt
     * @param string $mask
     * @param int $n
     * @param ImageSizeEnum $size
     * @param ImageResponseEnum $response_format
     * @param string $user
     *
     * @return self
     */
    public function createEdit(string $image, string $prompt, string $mask = '', int $n = 1, ImageSizeEnum $size = ImageSizeEnum::is1024, ImageResponseEnum $response_format = ImageResponseEnum::URL, string $user = ''): self
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
            "size" => $size->value,
            "response_format" => $response_format->value,
        ];

        if (!empty($mask)) {
            $payload["mask"] = curl_file_create($mask);
        }

        if (!empty($user)) {
            $payload["user"] = $user;
        }

        $this->request = $this->client->post(
            self::EDIT_END_POINT,
            $payload,
            params: ['timeout' => 60]
        );

        return $this;
    }
}
