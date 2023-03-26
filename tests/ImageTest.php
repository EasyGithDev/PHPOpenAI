<?php

namespace EasyGithDev\PHPOpenAI;

use EasyGithDev\PHPOpenAI\Images\ImageSize;
use PHPUnit\Framework\TestCase;

final class ImageTest extends TestCase
{

    public function testCreate()
    {
        $response = (new OpenAIApi(getenv('OPENAI_API_KEY')))->Image()->create(
            "a rabbit inside a beautiful garden, 32 bit isometric",
            n: 1,
            size: ImageSize::is256,
        )->getResponse();

        $this->assertEquals(200, $response->getHttpCode());
    }

    public function testVariation()
    {
        $response = (new OpenAIApi(getenv('OPENAI_API_KEY')))->Image()->createVariation(
            __DIR__ . '/../assets/image_variation_original.png',
            n: 1,
            size: ImageSize::is256
        )->getResponse();

        $this->assertEquals(200, $response->getHttpCode());
    }

    public function testEdit()
    {
        $response = (new OpenAIApi(getenv('OPENAI_API_KEY')))->Image()->createEdit(
            image: __DIR__ . '/../assets/image_edit_original.png',
            mask: __DIR__ . '/../assets/image_edit_mask2.png',
            prompt: 'a sunlit indoor lounge area with a pool containing a flamingo',
            size: ImageSize::is256,
        )->getResponse();

        $this->assertEquals(200, $response->getHttpCode());
    }
}
