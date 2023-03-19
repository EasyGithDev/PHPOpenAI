<?php

namespace EasyGithDev\PHPOpenAI\Images;

use EasyGithDev\PHPOpenAI\Curl;
use EasyGithDev\PHPOpenAI\Response;
use Exception;

class Image
{
    const MAX_PROMPT_CHARS = 1000;
    const END_POINT = '/images';
    const VARIATION_END_POINT = self::END_POINT . '/variations';
    const EDIT_END_POINT = self::END_POINT . '/edits';

    protected Curl $curl;
    protected string $apiUrl;
    protected array $headers = [];

    /**
     * @param string $apiUrl
     * @param array $headers
     */
    function __construct(string $apiUrl, array $headers)
    {
        $this->curl = new Curl;
        $this->apiUrl = $apiUrl;
        $this->headers = $headers;
    }

   
    /**
     * @param string $prompt
     * @param int $n
     * @param ImageSize $size
     * @param ResponseFormat $response_format
     * @param string $user
     * 
     * @return Response
     */
    function create(string $prompt, int $n = 1, ImageSize $size = ImageSize::is1024, ResponseFormat $response_format = ResponseFormat::URL, string $user = ''): Response
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
            ->setUrl($this->apiUrl . self::END_POINT . '/generations')
            ->setHeaders(
                $this->headers
            )
            ->setPayload(
                json_encode($payload)
            )
            ->exec();

        $this->curl->close();

        return $response;
    }

  
    /**
     * @param string $image
     * @param int $n
     * @param ImageSize $size
     * @param ResponseFormat $response_format
     * @param string $user
     * 
     * @return Response
     */
    function createVariation(string $image, int $n = 1, ImageSize $size = ImageSize::is1024, ResponseFormat $response_format = ResponseFormat::URL, string $user = ''): Response
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
            ->setUrl($this->apiUrl . self::VARIATION_END_POINT)
            ->setHeaders(
                $this->headers
            )
            ->setPayload($payload)
            ->exec();

        $this->curl->close();

        return $response;
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
     * @return Response
     */
    function createEdit(string $image, string $prompt, string $mask = '', int $n = 1, ImageSize $size = ImageSize::is1024, ResponseFormat $response_format = ResponseFormat::URL, string $user = ''): Response
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
            ->setUrl($this->apiUrl . self::EDIT_END_POINT)
            ->setHeaders(
                $this->headers
            )
            ->setPayload($payload)
            ->exec();

        $this->curl->close();

        return $response;
    }
}
