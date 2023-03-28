<?php

namespace EasyGithDev\PHPOpenAI\Helpers;

enum AudioResponseEnum: string
{
    case JSON =  'json';
    case TEXT = 'text';
    case SRT = 'srt';
    case VERBOSE_JSON = 'verbose_json';
    case VTT = 'vtt';
}
