<?php

use EasyGithDev\PHPOpenAI\Models\ModelEnum;
use EasyGithDev\PHPOpenAI\OpenAIApi;

require __DIR__ . '/../../vendor/autoload.php';

$response = (new OpenAIApi('BAD KEY'))->Completion()->create(
    ModelEnum::TEXT_DAVINCI_003,
    "Say this is a test",
);

if (!$response->isOk()) {
    $err = $response->getError();
    echo $err->message, ' ',
    $err->type, ' ',
    $err->param, ' ',
    $err->code;
}
