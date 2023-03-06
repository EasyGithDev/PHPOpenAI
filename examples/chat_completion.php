<?php

use EasyGithDev\PHPOpenAI\Chat\ChatCompletion;
use EasyGithDev\PHPOpenAI\Chat\Message;
use EasyGithDev\PHPOpenAI\Chat\Model;

require __DIR__ . '/../vendor/autoload.php';

$apiKey = "XXXXXXX YOUR KEY";
if (file_exists(__DIR__ . '/key.php')) {
    require __DIR__ . '/key.php';
}

$response = (new ChatCompletion($apiKey))->create(
    Model::gpt_3_5_turbo_0301,
    [
        new Message('user', 'Hello!'),
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