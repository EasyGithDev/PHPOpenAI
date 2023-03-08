<?php

namespace EasyGithDev\PHPOpenAI\Speech2text;

enum ResponseFormat: string
{

    case JSON =  'json';
    case TEXT = 'text';
    case SRT = 'srt';
    case VERBOSE_JSON = 'verbose_json';
    case VTT = 'vtt';
}
