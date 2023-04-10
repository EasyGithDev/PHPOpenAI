<?php

namespace EasyGithDev\PHPOpenAI\Helpers;

enum ContentTypeEnum: string
{
    case HTML = "text/html";
    case TEXT = "text/plain";
    case XML = "application/xml";
    case JSON = "application/json";
    case PDF = "application/pdf";
    case ZIP = "application/zip";
    case GZIP = "application/gzip";
    case MSWORD = "application/msword";
    case OCTET = "application/octet-stream";
    case OGG = "application/ogg";
    case MP4 = "video/mp4";
    case MPEG = "video/mpeg";
    case AVI = "video/x-msvideo";
    case PNG = "image/png";
    case JPEG = "image/jpeg";
    case GIF = "image/gif";
    case SVG = "image/svg+xml";

    public function toHeaderString(): string
    {
        return 'Content-Type: ' . $this->value;
    }

    public function toHeaderArray(): array
    {
        return ['Content-Type: ' . $this->value];
    }
}
