<?php

use EasyGithDev\PHPOpenAI\Configuration;
use EasyGithDev\PHPOpenAI\OpenAIApi;

require __DIR__ . '/../../vendor/autoload.php';

$apiKey = "XXXXXXX YOUR KEY";
if (file_exists(Configuration::$_configDir . '/key.php')) {
    $apiKey = require Configuration::$_configDir . '/key.php';
}

$configuration = new Configuration($apiKey);
$openAIApi = new OpenAIApi($configuration);
$file = $openAIApi->File();

$response = $file->download('file-EmrKv0H0CpZzk6ELaGJkhN1V');
$json_response = json_decode($response);

// Unable to test at this moment
// "error": {
//     "message": "To help mitigate abuse, downloading of fine-tune training files is disabled for free accounts.",
//     "type": "invalid_request_error",
//     "param": null,
//     "code": null
//   }

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>File download</title>
</head>

<body>

    <div>
        <label>Response :
            <textarea name="response" id="response" cols="100" rows="30"><?= $response ?></textarea>
        </label>
    </div>

</body>

</html>