<?php

use EasyGithDev\PHPOpenAI\Configuration;
use EasyGithDev\PHPOpenAI\Model;
use EasyGithDev\PHPOpenAI\OpenAIApi;

require __DIR__ . '/../../vendor/autoload.php';

$apiKey = "XXXXXXX YOUR KEY";
if (file_exists(Configuration::$_configDir . '/key.php')) {
    $apiKey = require Configuration::$_configDir . '/key.php';
}

$prompt = "Create a SQL request to find all users who live in California and have over 1000 credits:";

$response = (new OpenAIApi($apiKey))->Completion()->create(
    Model::TEXT_DAVINCI_003,
    prompt: $prompt,
    temperature: 0.3,
    max_tokens: 60,
    top_p: 1.0,
    frequency_penalty: 0.0,
    presence_penalty: 0.0
);

$jsonResponse = json_decode($response);

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Sql example</title>
</head>

<body>

    <div>
        <label>Prompt :
            <?= $prompt ?>
        </label>
    </div>

    <div>
        <?= nl2br(trim($jsonResponse->choices[0]->text)) ?>
    </div>
</body>

</html>