<?php

namespace EasyGithDev\PHPOpenAI;

use EasyGithDev\PHPOpenAI\Helpers\ImageSizeEnum;
use EasyGithDev\PHPOpenAI\Validators\StatusValidator;
use PHPUnit\Framework\TestCase;

final class ImageTest extends TestCase
{

    public function testCreate()
    {
        $handler = (new OpenAIClient(getenv('OPENAI_API_KEY')))
            ->Image()
            ->create(
                "a rabbit inside a beautiful garden, 32 bit isometric",
                n: 1,
                size: ImageSizeEnum::is256,
                response_format: 'url',
                user: 'phpunit'
            );

        $response = $handler->getResponse();
        $contentTypeValidator = $handler->getContentTypeValidator();

        $this->assertEquals(true, (new StatusValidator($response))->validate());
        $this->assertEquals(true, (new $contentTypeValidator($response))->validate());
    }

    public function testCreateWithString()
    {
        $handler = (new OpenAIClient(getenv('OPENAI_API_KEY')))
            ->Image()
            ->create(
                "a rabbit inside a beautiful garden, 32 bit isometric",
                n: 1,
                size: '256x256',
                response_format: 'url',
                user: 'phpunit'
            );

        $response = $handler->getResponse();
        $contentTypeValidator = $handler->getContentTypeValidator();

        $this->assertEquals(true, (new StatusValidator($response))->validate());
        $this->assertEquals(true, (new $contentTypeValidator($response))->validate());
    }

    public function testVariation()
    {
        $handler = (new OpenAIClient(getenv('OPENAI_API_KEY')))
            ->Image()
            ->createVariation(
                __DIR__ . '/../assets/image_variation_original.png',
                n: 1,
                size: ImageSizeEnum::is256,
                user: 'phpunit'
            );

        $response = $handler->getResponse();
        $contentTypeValidator = $handler->getContentTypeValidator();

        $this->assertEquals(true, (new StatusValidator($response))->validate());
        $this->assertEquals(true, (new $contentTypeValidator($response))->validate());
    }

    public function testEdit()
    {
        $handler = (new OpenAIClient(getenv('OPENAI_API_KEY')))
            ->Image()
            ->createEdit(
                image: __DIR__ . '/../assets/image_edit_original.png',
                mask: __DIR__ . '/../assets/image_edit_mask2.png',
                prompt: 'a sunlit indoor lounge area with a pool containing a flamingo',
                size: ImageSizeEnum::is256,
                user: 'phpunit'
            );

        $response = $handler->getResponse();
        $contentTypeValidator = $handler->getContentTypeValidator();

        $this->assertEquals(true, (new StatusValidator($response))->validate());
        $this->assertEquals(true, (new $contentTypeValidator($response))->validate());
    }
}
