<?php

namespace EasyGithDev\PHPOpenAI\Curl;

use EasyGithDev\PHPOpenAI\Exceptions\ApiException;
use EasyGithDev\PHPOpenAI\Helpers\ContentTypeEnum;
use EasyGithDev\PHPOpenAI\Validators\StatusValidator;

/**
 * This class handle the output from a cURL request.
 * It has several methods that are used to validate and parse the cUrl response.
 */
class CurlOutput
{
    public function __construct(protected CurlResponse $response)
    {
    }

    /**
     * Check the status code.
     * It will throw an exception if an error is occuring
     *
     * @return self
     */
    public function checkStatus(): self
    {
        if (!(new StatusValidator($this->response))->validate()) {
            throw new ApiException($this->formatError($this->response));
        }

        return $this;
    }

    /**
     * Validate the content-type.
     * It will throw an exception if an error is occuring
     *
     * @param string $contentType
     *
     * @return self
     */
    public function checkContentType(string $contentType): self
    {
        if (!(new $contentType($this->response))->validate()) {
            throw new ApiException(\sprintf('Unsupported content type: %s', $this->response->getHeaderLine('Content-Type')));
        }

        return $this;
    }

    /**
     * Transform the body of the response into array
     * or object
     * @param bool $asArray
     *
     * @return array|\stdClass
     */
    public function decodeResponse(bool $asArray = false): array|\stdClass
    {
        if (ContentTypeEnum::tryFrom($this->response->getHeaderLine()) != ContentTypeEnum::JSON) {
            if ($asArray) {
                return ['text' => $this->response->getBody()];
            } else {
                $obj = new \stdClass();
                $obj->text = $this->response->getBody();
                return $obj;
            }
        }

        $body =  json_decode($this->response, $asArray);

        if (\json_last_error()) {
            throw new ApiException(
                'Failed to parse JSON response body: ' . \json_last_error_msg()
            );
        }

        return $body;
    }

    /**
     * Format the response error into a trsing
     *
     * @return string
     */
    public function formatError(): string
    {
        $body = json_decode($this->response);

        if (\json_last_error()) {
            return \sprintf(
                "status: %s\nmessage: %s\ntype: %s\param: %s\ncode: %s\n",
                $this->response->getStatusCode(),
                $this->response->getBody(),
                '',
                '',
                '',
            );
        }

        return \sprintf(
            "status: %s\nmessage: %s\ntype: %s\param: %s\ncode: %s\n",
            $this->response->getStatusCode(),
            $body->error->message,
            $body->error->type,
            $body->error->param,
            $body->error->code,
        );
    }
}
