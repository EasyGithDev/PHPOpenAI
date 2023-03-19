<?php

use EasyGithDev\PHPOpenAI\Configuration;
use EasyGithDev\PHPOpenAI\Models\ModelEnum;
use EasyGithDev\PHPOpenAI\OpenAIApi;

require __DIR__ . '/../../vendor/autoload.php';

$apiKey = "XXXXXXX YOUR KEY";
if (file_exists(Configuration::$_configDir . '/key.php')) {
    $apiKey = require Configuration::$_configDir . '/key.php';
}

$response = (new OpenAIApi($apiKey))->Embedding()->create(
    ModelEnum::TEXT_EMBEDDING_ADA_002,
    "The food was delicious and the waiter...",
);

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Embedding using short syntaxe</title>
</head>

<body>

    <div>
        <label>Response :
            <textarea name="response" id="response" cols="100" rows="30"><?= $response ?></textarea>
        </label>
    </div>

</body>

</html>