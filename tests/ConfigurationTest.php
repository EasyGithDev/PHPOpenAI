<?php

namespace EasyGithDev\PHPOpenAI;

use EasyGithDev\PHPOpenAI\Validators\StatusValidator;
use PHPUnit\Framework\TestCase;

final class ConfigurationTest extends TestCase
{

    public function testApiKey()
    {
        $handler = (new OpenAIClient(getenv('OPENAI_API_KEY')))
            ->Completion()
            ->addCurlParam('debug', true)
            ->create(
                "text-davinci-003",
                "Say this is a test",
                user: 'phpunit'
            );

        $response = $handler->getResponse();
        $contentTypeValidator = $handler->getContentTypeValidator();

        $this->assertEquals(true, (new StatusValidator($response))->validate());
        $this->assertEquals(true, (new $contentTypeValidator($response))->validate());

        $log = $response->getLog();
        $this->assertEquals(str_contains($log, getenv('OPENAI_API_KEY')), true);
    }

    public function testOrganization()
    {
        if (empty(getenv('OPENAI_API_ORG'))) {
            $this->markTestSkipped('testOrganization is skiped.');
        } else {
            $handler = (new OpenAIClient(getenv('OPENAI_API_KEY'), getenv('OPENAI_API_ORG')))
                ->Completion()
                ->addCurlParam('debug', true)
                ->create(
                    "text-davinci-003",
                    "Say this is a test",
                    user: 'phpunit'
                );

            $response = $handler->getResponse();
            $contentTypeValidator = $handler->getContentTypeValidator();

            $this->assertEquals(true, (new StatusValidator($response))->validate());
            $this->assertEquals(true, (new $contentTypeValidator($response))->validate());

            $log = $response->getLog();
            $this->assertEquals(str_contains($log, getenv('OPENAI_API_KEY')), true);
            $this->assertEquals(str_contains($log, getenv('OPENAI_API_ORG')), true);
        }
    }
}
