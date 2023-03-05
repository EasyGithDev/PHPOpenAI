<?php

use EasyGithDev\PHPOpenAI\Image;
use EasyGithDev\PHPOpenAI\ImageSize;

require __DIR__ . '/../src/autoload.php';

function saveImg($url)
{
    $content =  file_get_contents($url);
    file_put_contents('dall-e.png', $content);
}

function displayUrl($url)
{
    return '<img src="' . $url . '" />';
}

$apiKey = "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";
$prompt = "A woman with long black hair with her cat by the cliff, Japanese poster graphics";

$response = (new Image($apiKey))->create(
    $prompt,
    size: ImageSize::is512
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