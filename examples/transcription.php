<?php

use EasyGithDev\PHPOpenAI\Configuration;
use EasyGithDev\PHPOpenAI\Model;
use EasyGithDev\PHPOpenAI\OpenAIApi;
use EasyGithDev\PHPOpenAI\Speech2text\ResponseFormat;

require __DIR__ . '/../vendor/autoload.php';

$apiKey = "XXXXXXX YOUR KEY";
if (file_exists(__DIR__ . '/key.php')) {
    require __DIR__ . '/key.php';
}

$configuration = new Configuration($apiKey);
$openAIApi = new OpenAIApi($configuration);
$audio = $openAIApi->Transcription();

$response = $audio->transcription(
    __DIR__ . '/../assets/Dear Future Husband.mp3',
    Model::WHISPER_1,
    responseFormat: ResponseFormat::SRT
);

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

</body>

</html>