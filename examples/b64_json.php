<?php

use EasyGithDev\PHPOpenAI\Image;
use EasyGithDev\PHPOpenAI\ImageSize;
use EasyGithDev\PHPOpenAI\ResponseFormat;

require __DIR__ . '/../vendor/autoload.php';

function displayImg($data)
{
    return '<img src="data:image/png;base64, ' . $data . '" alt="DALL-E 2" />';
}

$apiKey = "XXXXXXX YOUR KEY";

require __DIR__ . '/key.php';

$prompt = "An old poster with a woman and a cat, in the style of Charley Harper";

$response = (new Image($apiKey))->create(
    $prompt,
    n: 2,
    size: ImageSize::is256,
    response_format: ResponseFormat::B64_JSON
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

    <!-- <div>
        <label>Payload :
            <textarea name="payload" id="payload" cols="100" rows="30"><?= $payload ?></textarea>
        </label>
    </div> -->

    <div>
        <label>Response :
            <textarea name="response" id="response" cols="100" rows="30"><?= $response ?></textarea>
        </label>
    </div>

    <?php foreach ($json_response['data'] as $image) : ?>
        <div> <?= displayImg($image['b64_json']) ?> </div>
    <?php endforeach; ?>

</body>

</html>