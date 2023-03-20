<?php

use EasyGithDev\PHPOpenAI\Configuration;
use EasyGithDev\PHPOpenAI\OpenAIApi;

require __DIR__ . '/../../vendor/autoload.php';

$apiKey = "XXXXXXX YOUR KEY";
if (file_exists(Configuration::$_configDir . '/key.php')) {
    $apiKey = require Configuration::$_configDir . '/key.php';
}
if (isset($_POST['submit'])) {
    $response = (new OpenAIApi($apiKey))
        ->File()
        ->delete($_POST['file_id']);
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>File delete</title>
</head>

<body>
    <form action="<?= $_SERVER['PHP_SELF']  ?>" method="POST">
        <input type="text" name='file_id'>
        <input type="submit" name='submit'>
    </form>
    <?php if (isset($_POST['submit'])) : ?>

        <div>
            <textarea name="response" id="response" cols="100" rows="30"><?= $response ?></textarea>
        </div>
        <?= ($response->toObject()->deleted) ? 'file is deleted' : 'not deleted' ?>
    <?php endif ?>

</body>

</html>