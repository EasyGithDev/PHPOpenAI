<?php

namespace EasyGithDev\PHPOpenAI\Images;

use EasyGithDev\PHPOpenAI\Curl\CurlRequest;
use EasyGithDev\PHPOpenAI\Curl\CurlResponse;
use EasyGithDev\PHPOpenAI\Curl\Responses\ImageResponse;
use Exception;

class Image
{
    public const MAX_PROMPT_CHARS = 1000;
    public const END_POINT = '/images';
    public const VARIATION_END_POINT = self::END_POINT . '/variations';
    public const EDIT_END_POINT = self::END_POINT . '/edits';

    /**
     * @param string $apiUrl
     * @param array $headers
     */
    public function __construct(protected CurlRequest $curl, protected CurlResponse $response)
    {
    }


    /**
     * @param string $prompt
     * @param int $n
     * @param ImageSize $size
     * @param ResponseFormat $response_format
     * @param string $user
     *
     * @return CurlResponse
     */
    public function create(string $prompt, int $n = 1, ImageSize $size = ImageSize::is1024, ResponseFormat $response_format = ResponseFormat::URL, string $user = ''): ImageResponse
    {
        if (mb_strlen($prompt) > self::MAX_PROMPT_CHARS) {
            throw new \Exception("Max prompt is 1000 chars");
        }

        if ($n < 1 or $n > 10) {
            throw new \Exception('$n is between 1 and 10');
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

        $response =  $this->curl
            ->setUrl(self::END_POINT . '/generations')
            ->setMethod(CurlRequest::CURL_POST)
            ->setPayload(
                json_encode($payload)
            )
            ->setHeaders(['Content-Type: application/json'])
            ->exec();

        $this->curl->close();

        return $this->response->setInfos($response);
    }


    /**
     * @param string $image
     * @param int $n
     * @param ImageSize $size
     * @param ResponseFormat $response_format
     * @param string $user
     *
     * @return CurlResponse
     */
    public function createVariation(string $image, int $n = 1, ImageSize $size = ImageSize::is1024, ResponseFormat $response_format = ResponseFormat::URL, string $user = ''): ImageResponse
    {
        if (!file_exists($image)) {
            throw new Exception("Unable to locate file: $image");
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

        $response =  $this->curl
            ->setUrl(self::VARIATION_END_POINT)
            ->setMethod(CurlRequest::CURL_POST)
            ->setPayload($payload)
            ->exec();

        $this->curl->close();

        return $this->response->setInfos($response);
    }


    /**
     * @param string $image
     * @param string $prompt
     * @param string $mask
     * @param int $n
     * @param ImageSize $size
     * @param ResponseFormat $response_format
     * @param string $user
     *
     * @return CurlResponse
     */
    public function createEdit(string $image, string $prompt, string $mask = '', int $n = 1, ImageSize $size = ImageSize::is1024, ResponseFormat $response_format = ResponseFormat::URL, string $user = ''): ImageResponse
    {
        if (!file_exists($image)) {
            throw new Exception("Unable to locate file: $image");
        }

        if (!empty($mask) && !file_exists($mask)) {
            throw new Exception("Unable to locate mask: $mask");
        }

        if (mb_strlen($prompt) > 1000) {
            throw new \Exception("Prompt max char is : 1000");
        }

        if ($n < 1 or $n > 10) {
            throw new \Exception('$n is between 1 and 10');
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

        $response =  $this->curl
            ->setUrl(self::EDIT_END_POINT)
            ->setMethod(CurlRequest::CURL_POST)
            ->setPayload($payload)
            ->exec();

        $this->curl->close();

        return $this->response->setInfos($response);
    }
}
