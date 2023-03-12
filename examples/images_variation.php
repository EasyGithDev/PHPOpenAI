<?php

use EasyGithDev\PHPOpenAI\Configuration;
use EasyGithDev\PHPOpenAI\Images\ImageSize;
use EasyGithDev\PHPOpenAI\OpenAIApi;

require __DIR__ . '/../vendor/autoload.php';

function displayUrl($url)
{
    return '<img src="' . $url . '" />';
}

$apiKey = "XXXXXXX YOUR KEY";
if (file_exists(Configuration::$_configDir . '/key.php')) {
    $apiKey = require Configuration::$_configDir . '/key.php';
}

$configuration = new Configuration($apiKey);
$openAIApi = new OpenAIApi($configuration);
$image = $openAIApi->ImageVariation();

$response = $image->createVariation(
    __DIR__ . '/../assets/image_variation_original.png',
    n:2,
    size:ImageSize::is256
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

    <?php foreach ($json_response['data'] as $image) : ?>
        <div> <?= displayUrl($image['url']) ?> </div>
    <?php endforeach; ?>

</body>

</html>