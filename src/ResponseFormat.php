<?php
namespace EasyGithDev\PHPOpenAI;

enum ResponseFormat: string
{
    case URL = 'url';
    case B64_JSON = 'b64_json';
}
