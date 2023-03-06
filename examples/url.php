<?php

use EasyGithDev\PHPOpenAI\Images\Image;
use EasyGithDev\PHPOpenAI\Images\ImageSize;

require __DIR__ . '/../vendor/autoload.php';

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
if (file_exists(__DIR__ . '/key.php')) {
    require __DIR__ . '/key.php';
}

$prompt = "a rabbit inside a beautiful garden, 32 bit isometric";

$response = (new Image($apiKey))->create(
    $prompt,
    n:4,
    size: ImageSize::is256
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