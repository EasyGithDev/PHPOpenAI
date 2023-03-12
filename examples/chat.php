<?php

use EasyGithDev\PHPOpenAI\Chats\Message;
use EasyGithDev\PHPOpenAI\Configuration;
use EasyGithDev\PHPOpenAI\Model;
use EasyGithDev\PHPOpenAI\OpenAIApi;

require __DIR__ . '/../vendor/autoload.php';

$apiKey = "XXXXXXX YOUR KEY";
if (file_exists(Configuration::$_configDir . '/key.php')) {
    $apiKey = require Configuration::$_configDir . '/key.php';
}

$configuration = new Configuration($apiKey);
$openAIApi = new OpenAIApi($configuration);
$chatCompletion = $openAIApi->Chat();

$response = $chatCompletion->create(
    Model::GPT_3_5_TURBO,
    [
        new Message(Message::ROLE_SYSTEM, "You are a helpful assistant."),
        new Message(Message::ROLE_USER, "Who won the world series in 2020?"),
        new Message(Message::ROLE_ASSISTANT, "The Los Angeles Dodgers won the World Series in 2020."),
        new Message(Message::ROLE_USER, "Where was it played?"),
    ]
);

$json_response = json_decode($response, true);

?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Titre de la page</title>
    <!-- <link rel="stylesheet" href="style.css">
    <script src="script.js"></script> -->
</head>

<body>

    <div>
        <label>Response :
            <textarea name="response" id="response" cols="100" rows="30"><?= $response ?></textarea>
        </label>
    </div>

    <?php foreach ($json_response['choices'] as $choice) : ?>
        <div> <?= $choice['message']['content'] ?> </div>
    <?php endforeach; ?>

</body>

</html>