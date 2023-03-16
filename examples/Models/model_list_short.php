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
$json_response = json_decode($response);

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Model list</title>
</head>

<body>

    <div>
        <label>Response :
            <textarea name="response" id="response" cols="100" rows="30"><?= $response ?></textarea>
        </label>
    </div>


    <?php foreach ($json_response->data as $model) : ?>
        <div>
            <?= 'case ' . normalize($model->id) . '="' .  $model->id . '";' ?>
        </div>
    <?php endforeach; ?>

</body>

</html>