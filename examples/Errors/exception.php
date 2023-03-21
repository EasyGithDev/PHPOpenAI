<?php

use EasyGithDev\PHPOpenAI\Exceptions\ApiException;
use EasyGithDev\PHPOpenAI\Models\ModelEnum;
use EasyGithDev\PHPOpenAI\OpenAIApi;

require __DIR__ . '/../../vendor/autoload.php';

try {
    $response = (new OpenAIApi('BAD KEY'))->Completion()->create(
        ModelEnum::TEXT_DAVINCI_003,
        "Say this is a test",
    )->throwable();
} catch (ApiException $e) {
    echo nl2br($e->getMessage());
    die;
}
