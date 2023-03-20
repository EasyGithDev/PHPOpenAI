<?php

use EasyGithDev\PHPOpenAI\Configuration;
use EasyGithDev\PHPOpenAI\OpenAIApi;

require __DIR__ . '/../../vendor/autoload.php';

$apiKey = "XXXXXXX YOUR KEY";
if (file_exists(Configuration::$_configDir . '/key.php')) {
    $apiKey = require Configuration::$_configDir . '/key.php';
}

$response = (new OpenAIApi($apiKey))->Edit()->create(
    input: "What day of the wek is it?",
    instruction: "Fix the spelling mistakes",
);

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Edit</title>
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