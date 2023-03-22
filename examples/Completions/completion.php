<?php

use EasyGithDev\PHPOpenAI\Configuration;
use EasyGithDev\PHPOpenAI\Models\ModelEnum;
use EasyGithDev\PHPOpenAI\OpenAIApi;

require __DIR__ . '/../../vendor/autoload.php';

$apiKey = "XXXXXXX YOUR KEY";
if (file_exists(Configuration::$_configDir . '/key.php')) {
    $apiKey = require Configuration::$_configDir . '/key.php';
}

$response = (new OpenAIApi($apiKey))->Completion()->create(
    ModelEnum::TEXT_DAVINCI_003,
    "Say this is a test",
);

// Response as a string
echo $response;

// Response as associative array
echo '<pre>', print_r($response->toArray(), true), '</pre>';

// Response as stClass object
echo '<pre>', print_r($response->toObject(), true), '</pre>';

///////////////////////////////////////////////
// Methods specific to the completion object.
///////////////////////////////////////////////

// Get all choices as stClass object
foreach ($response->choices() as $choice) {
    echo '<pre>', print_r($choice, true), '</pre>';
}

// Get one choice as stClass object
echo $response->choice(0)->text;

// Get all text as string array
echo '<pre>', print_r($response->fetchAll(), true), '</pre>';

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Completion using short syntaxe</title>
</head>

<body>

    <div>
        <textarea name="response" id="response" cols="100" rows="30"><?= $response ?></textarea>
    </div>

    <?php foreach ($response->fetchAll() as $text) : ?>
        <div> <?= $text ?> </div>
    <?php endforeach; ?>

</body>

</html>