<?php

use EasyGithDev\PHPOpenAI\Configuration;
use EasyGithDev\PHPOpenAI\OpenAIApi;

require __DIR__ . '/../../vendor/autoload.php';

$apiKey = "XXXXXXX YOUR KEY";
if (file_exists(Configuration::$_configDir . '/key.php')) {
    $apiKey = require Configuration::$_configDir . '/key.php';
}

$response = (new OpenAIApi($apiKey))
    ->File()
    ->create(
        __DIR__ . '/../../assets/mydata.jsonl',
        'fine-tune',
    );
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>File upload</title>
</head>

<body>

    <div>
        <textarea name="response" id="response" cols="100" rows="30"><?= $response ?></textarea>
    </div>

    <?= $response->toObject()->filename ?>

</body>

</html>