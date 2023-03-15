<?php

use EasyGithDev\PHPOpenAI\Configuration;
use EasyGithDev\PHPOpenAI\Model;
use EasyGithDev\PHPOpenAI\OpenAIApi;

require __DIR__ . '/../../vendor/autoload.php';

$text = '';
if (isset($_POST['submit'])) {
    $apiKey = "XXXXXXX YOUR KEY";
    if (file_exists(Configuration::$_configDir . '/key.php')) {
        $apiKey = require Configuration::$_configDir . '/key.php';
    }

    $prompt = $_POST['text'] . PHP_EOL . 'tl;dr:';

    $response = (new OpenAIApi($apiKey))->Completion()->create(
        Model::TEXT_DAVINCI_003,
        prompt: $prompt,
        temperature: 0.7,
        max_tokens: 60,
        top_p: 1.0,
        frequency_penalty: 0.0,
        presence_penalty: 1
    );

    $jsonResponse = json_decode($response);
    $text = nl2br(trim($jsonResponse->choices[0]->text));
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Summarize example</title>
</head>

<body>

    Summarize text by adding a 'tl;dr:' to the end of a text passage. It shows that the API understands how to perform a number of tasks with no instructions.

    <div>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
            <label>Enter a text :
                <textarea type="text" name="text"></textarea>
            </label>
            <input type="submit" name="submit">
        </form>
    </div>

    <div>
        <?= $text ?>
    </div>
</body>

</html>