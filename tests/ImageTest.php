<?php

namespace EasyGithDev\PHPOpenAI;

use EasyGithDev\PHPOpenAI\Images\ImageSize;
use EasyGithDev\PHPOpenAI\Models\ModelEnum;
use PHPUnit\Framework\TestCase;

final class ImageTest extends TestCase
{
    protected $apiKey;
    protected $client;

    function __construct()
    {
        if (file_exists(Configuration::$_configDir . '/key.php')) {
            $this->apiKey = require Configuration::$_configDir . '/key.php';
        }
        $configuration = new Configuration($this->apiKey);
        $this->client = new OpenAIApi($configuration);

        parent::__construct();
    }

    public function testCreate()
    {

        $response = $this->client->Image()->create(
            "a rabbit inside a beautiful garden, 32 bit isometric",
            n: 1,
            size: ImageSize::is256,
        );

        $this->assertEquals(200, $response->getHttpCode());
    }

    public function testVariation()
    {

        $response = $this->client->ImageVariation()->createVariation(
            __DIR__ . '/../assets/image_variation_original.png',
            n: 1,
            size: ImageSize::is256
        );

        $this->assertEquals(200, $response->getHttpCode());
    }

    public function testEdit()
    {

        $response = $this->client->ImageEdit()->createEdit(
            image: __DIR__ . '/../assets/image_edit_original.png',
            mask: __DIR__ . '/../assets/image_edit_mask2.png',
            prompt: 'a sunlit indoor lounge area with a pool containing a flamingo',
            size: ImageSize::is256,
        );

        $this->assertEquals(200, $response->getHttpCode());
    }
}
