<?php

use EasyGithDev\PHPOpenAI\Configuration;
use EasyGithDev\PHPOpenAI\OpenAIApi;

require __DIR__ . '/../../vendor/autoload.php';

function normalize($str)
{
    $str =  str_replace(['-', '.', ':'], ['_', '_', '_'], $str);
    return mb_strtoupper($str);
}

$apiKey = "XXXXXXX YOUR KEY";
if (file_exists(Configuration::$_configDir . '/key.php')) {
    $apiKey = require Configuration::$_configDir . '/key.php';
}

$response = (new OpenAIApi($apiKey))->Model()->list();

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Model list</title>
</head>

<body>

    <div>
        <textarea name="response" id="response" cols="100" rows="30"><?= $response ?></textarea>
    </div>


    <?php foreach ($response->fetchAll() as $model) : ?>
        <div>
            <?= 'case ' . normalize($model) . '="' .  $model . '";' ?>
        </div>
    <?php endforeach; ?>

</body>

</html>