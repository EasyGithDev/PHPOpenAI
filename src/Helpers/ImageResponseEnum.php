<?php

namespace EasyGithDev\PHPOpenAI\Helpers;

enum ImageResponseEnum: string
{
    case URL = 'url';
    case B64_JSON = 'b64_json';
}
