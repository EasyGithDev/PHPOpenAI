<?php

use EasyGithDev\PHPOpenAI\Configuration;
use EasyGithDev\PHPOpenAI\Images\Image;
use EasyGithDev\PHPOpenAI\Images\ImageSize;
use EasyGithDev\PHPOpenAI\Images\ResponseFormat;
use EasyGithDev\PHPOpenAI\OpenAIApi;

require __DIR__ . '/../../vendor/autoload.php';

function displayImg($data)
{
    return '<img src="data:image/png;base64, ' . $data . '" alt="DALL-E 2" />';
}

$apiKey = "XXXXXXX YOUR KEY";
if (file_exists(Configuration::$_configDir . '/key.php')) {
    $apiKey = require Configuration::$_configDir . '/key.php';
}

$configuration = new Configuration($apiKey);
$openAIApi = new OpenAIApi($configuration);
$image = $openAIApi->Image();

$response = $image->create(
    "An old poster with a woman and a cat, in the style of Charley Harper",
    n: 2,
    size: ImageSize::is256,
    response_format: ResponseFormat::B64_JSON
);

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Image using b64 format</title>
</head>

<body>

    <div>
        <textarea name="response" id="response" cols="100" rows="30"><?= $response ?></textarea>
    </div>

    <?php foreach ($response->b64Images() as $image) : ?>
        <div> <?= displayImg($image) ?> </div>
    <?php endforeach; ?>

</body>

</html>