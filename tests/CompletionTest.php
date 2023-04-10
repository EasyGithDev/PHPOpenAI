<?php

namespace EasyGithDev\PHPOpenAI;

use EasyGithDev\PHPOpenAI\Helpers\ModelEnum;
use EasyGithDev\PHPOpenAI\Validators\StatusValidator;
use PHPUnit\Framework\TestCase;
use stdClass;

final class CompletionTest extends TestCase
{

    public function testCreate()
    {

        $handler = (new OpenAIClient(getenv('OPENAI_API_KEY')))
            ->Completion()
            ->create(
                "text-davinci-003",
                "Say this is a test",
                user: 'phpunit'
            );

        $response = $handler->getResponse();
        $contentTypeValidator = $handler->getContentTypeValidator();

        $this->assertEquals(true, (new StatusValidator($response))->validate());
        $this->assertEquals(true, (new $contentTypeValidator($response))->validate());
    }

    public function testStream()
    {
        $str = '';

        $handler = (new OpenAIClient(getenv('OPENAI_API_KEY')))
            ->Completion()
            ->setCallback(function ($ch, $data) use (&$str) {
                $jsonData = json_decode(str_replace('data: ', '', trim(trim($data), '"')));
                if ($jsonData && is_a($jsonData, stdClass::class)) {
                    $str .= $jsonData?->choices[0]->text;
                }
                return mb_strlen($data);
            })
            ->create(
                "text-davinci-003",
                "Say this is a test",
                stream: true,
                echo: true,
                user: 'phpunit'
            );

        $response = $handler->getResponse();

        $this->assertEquals(true, (new StatusValidator($response))->validate());
        $this->assertTrue(str_contains($str, 'Say this is a test'));
    }
}
