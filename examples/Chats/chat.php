<?php

use EasyGithDev\PHPOpenAI\Chats\Message;
use EasyGithDev\PHPOpenAI\Configuration;
use EasyGithDev\PHPOpenAI\Models\ModelEnum;
use EasyGithDev\PHPOpenAI\OpenAIApi;

require __DIR__ . '/../../vendor/autoload.php';

$apiKey = "XXXXXXX YOUR KEY";
if (file_exists(Configuration::$_configDir . '/key.php')) {
    $apiKey = require Configuration::$_configDir . '/key.php';
}

$response = (new OpenAIApi($apiKey))->Chat()->create(
    ModelEnum::GPT_3_5_TURBO,
    [
        new Message(Message::ROLE_SYSTEM, "You are a helpful assistant."),
        new Message(Message::ROLE_USER, "Who won the world series in 2020?"),
        new Message(Message::ROLE_ASSISTANT, "The Los Angeles Dodgers won the World Series in 2020."),
        new Message(Message::ROLE_USER, "Where was it played?"),
    ]
);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Chat completion</title>
</head>

<body>

    <div>
        <textarea name="response" id="response" cols="100" rows="30"><?= $response ?></textarea>
    </div>

    <?php foreach ($response->fetchAll() as $text) : ?>
        <div> <?= $text ?> </div>
    <?php endforeach; ?>

</body>

</html>