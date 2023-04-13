<?php

namespace EasyGithDev\PHPOpenAI\Contracts;

interface HeaderInterface
{
    /**
     * Get the value of headers
     * @return array
     */
    public function getHeaders(): array;

    /**
     * Set the value of headers
     *
     * @param array $headers
     *
     * @return self
     */
    public function setHeaders(array $headers): self;

    /**
     * Adding an element to the headers
     * @param string $header
     *
     * @return self
     */
    public function addHeader(string $header): self;
}
