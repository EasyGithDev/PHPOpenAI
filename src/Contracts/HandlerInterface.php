<?php

namespace EasyGithDev\PHPOpenAI\Contracts;

use EasyGithDev\PHPOpenAI\Curl\CurlRequest;
use EasyGithDev\PHPOpenAI\Curl\CurlResponse;

/**
 * This abstract class defines methods for handling HTTP requests and responses to the OpenAI API.
 *
 * Here are the key features of this class:
 *
 * It has a property named $request which represents
 * the HTTP request to be sent to the API.
 *
 * It has a property named $response which represents
 * the HTTP response returned by the API.
 *
 * It has a property named $client of type OpenAIClient,
 * which is used to send the HTTP request and receive the response.
 *
 * It has a property named $contentTypeValidator which is used
 * to validate the content type of the response received from the API.
 *
 * It has a property named $curlParams which contains
 * additional parameters to be included in the HTTP request.
 */
interface HandlerInterface
{
    /**
     * Set the request to the handler
     * @param CurlRequest $request
     *
     * @return void
     */
    public function setRequest(CurlRequest $request): void;

    /**
     * Get the request from the handler
     *
     * @return CurlRequest
     */
    public function getRequest(): CurlRequest;


    /**
     * Get the response from the handler
     * If the response exist, it will be returned
     * else the client will send the request and return
     * the response
     *
     * @return CurlResponse
     */
    public function getResponse(): CurlResponse;

    /**
     * Get the value of contentTypeValidator
     *
     * @return  string
     */
    public function getContentTypeValidator();

    /**
     * Add an additionnal parameter for curl request
     * @param string $key
     * @param mixed $value
     *
     * @return self
     */
    public function addCurlParam(string $key, mixed $value): self;

    /**
     * Get an array response from the handler
     * @return array
     */
    public function toArray(): array;

    /**
     * Get an object response from the handler
     *
     * @return \stdClass
     */
    public function toObject(): \stdClass;
}
