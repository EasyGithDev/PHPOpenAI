<?php

use EasyGithDev\PHPOpenAI\Configuration;
use EasyGithDev\PHPOpenAI\Images\ImageSize;
use EasyGithDev\PHPOpenAI\OpenAIApi;

require __DIR__ . '/../../vendor/autoload.php';

function saveImg($url)
{
    $content =  file_get_contents($url);
    file_put_contents('dall-e.png', $content);
}

function displayUrl($url)
{
    return '<img src="' . $url . '" />';
}

$apiKey = "XXXXXXX YOUR KEY";
if (file_exists(Configuration::$_configDir . '/key.php')) {
    $apiKey = require Configuration::$_configDir . '/key.php';
}

$response = (new OpenAIApi($apiKey))->Image()->create(
    "a rabbit inside a beautiful garden, 32 bit isometric",
    n: 2,
    size: ImageSize::is256,
);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Image using url format</title>
</head>

<body>

    <div>
        <textarea name="response" id="response" cols="100" rows="30"><?= $response ?></textarea>
    </div>

    <?php foreach ($response->urlImages() as $image) : ?>
        <div> <?= displayUrl($image) ?> </div>
    <?php endforeach; ?>

</body>

</html>