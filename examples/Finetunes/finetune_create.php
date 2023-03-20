<?php

use EasyGithDev\PHPOpenAI\Configuration;
use EasyGithDev\PHPOpenAI\OpenAIApi;

require __DIR__ . '/../../vendor/autoload.php';

$apiKey = "XXXXXXX YOUR KEY";
if (file_exists(Configuration::$_configDir . '/key.php')) {
    $apiKey = require Configuration::$_configDir . '/key.php';
}

$response = (new OpenAIApi($apiKey))
    ->FineTune()
    ->create(
       'file-TaUub0NiSnZ70YSgUoWqAS8K'
    );
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Finetune create</title>
</head>

<body>

    <div>
        <textarea name="response" id="response" cols="100" rows="30"><?= $response ?></textarea>
    </div>

    <?= $response->toObject()->id ?>

</body>

</html>