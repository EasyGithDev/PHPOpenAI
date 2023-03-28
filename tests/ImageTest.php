<?php

namespace EasyGithDev\PHPOpenAI;

use EasyGithDev\PHPOpenAI\Helpers\ImageSizeEnum;
use PHPUnit\Framework\TestCase;

final class ImageTest extends TestCase
{

    public function testCreate()
    {
        $response = (new OpenAIClient(getenv('OPENAI_API_KEY')))->Image()->create(
            "a rabbit inside a beautiful garden, 32 bit isometric",
            n: 1,
            size: ImageSizeEnum::is256,
        )->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testVariation()
    {
        $response = (new OpenAIClient(getenv('OPENAI_API_KEY')))->Image()->createVariation(
            __DIR__ . '/../assets/image_variation_original.png',
            n: 1,
            size: ImageSizeEnum::is256
        )->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testEdit()
    {
        $response = (new OpenAIClient(getenv('OPENAI_API_KEY')))->Image()->createEdit(
            image: __DIR__ . '/../assets/image_edit_original.png',
            mask: __DIR__ . '/../assets/image_edit_mask2.png',
            prompt: 'a sunlit indoor lounge area with a pool containing a flamingo',
            size: ImageSizeEnum::is256,
        )->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
    }
}
