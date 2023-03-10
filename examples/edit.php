<?php

use EasyGithDev\PHPOpenAI\Configuration;
use EasyGithDev\PHPOpenAI\Model;
use EasyGithDev\PHPOpenAI\OpenAIApi;

require __DIR__ . '/../vendor/autoload.php';


$apiKey = "XXXXXXX YOUR KEY";
if (file_exists(__DIR__ . '/key.php')) {
    require __DIR__ . '/key.php';
}

$configuration = new Configuration($apiKey);
$openAIApi = new OpenAIApi($configuration);
$edit = $openAIApi->Edit();
$response = $edit->create(
    input: "What day of the wek is it?",
    instruction: "Fix the spelling mistakes",
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

</body>

</html>