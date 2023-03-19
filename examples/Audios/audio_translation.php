<?php

use EasyGithDev\PHPOpenAI\Audios\ResponseFormat;
use EasyGithDev\PHPOpenAI\Configuration;
use EasyGithDev\PHPOpenAI\Models\ModelEnum;
use EasyGithDev\PHPOpenAI\OpenAIApi;


require __DIR__ . '/../../vendor/autoload.php';

$apiKey = "XXXXXXX YOUR KEY";
if (file_exists(Configuration::$_configDir . '/key.php')) {
    $apiKey = require Configuration::$_configDir . '/key.php';
}

$response = (new OpenAIApi($apiKey))->Audio()->translation(
    __DIR__ . '/../../assets/openai_fr.mp3',
    ModelEnum::WHISPER_1,
    responseFormat: ResponseFormat::TEXT
);

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Audio transcription</title>
</head>

<body>

    <div>
        <textarea name="response" id="response" cols="100" rows="30"><?= $response ?></textarea>
    </div>

    <div>
        <?= $response->text() ?>
    </div>
</body>

</html>