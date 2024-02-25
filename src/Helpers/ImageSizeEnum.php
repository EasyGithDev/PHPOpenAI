<?php

namespace EasyGithDev\PHPOpenAI\Helpers;

enum ImageSizeEnum: string
{
        // Dall-e-2 only
    case is256 = '256x256';
    case is512 = '512x512';

        // Dall-e-3 and Dall-e-2
    case is1024 = '1024x1024';

        // Dall-e-3 only
    case is1792x1024 = '1792x1024';
    case is1024x1792 = '1024x1792';
}
