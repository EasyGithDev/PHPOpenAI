<?php

function saveImg($url)
{
    $content =  file_get_contents($url);
    file_put_contents('dall-e.png', $content);
}

$apiKey = "XXXXXXX YOUR KEY";
if (file_exists(__DIR__ . '/key.php')) {
    require __DIR__ . '/key.php';
}

$url = "https://api.openai.com/v1/images/generations";

$payload = [
    "prompt" => "An old poster with a woman and a cat, in the style of Charley Harper",
    "n" => 1,
    "size" => "1024x1024",
];

$headers = [
    'Content-Type: application/json',
    "Authorization: Bearer $apiKey",
];

$ch = curl_init();
try {
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo curl_error($ch);
        die();
    }

    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($http_code == intval(200)) {
        // echo $response;
        $json_response = json_decode($response, true);
        $image_url = $json_response['data'][0]['url'];
        saveImg($image_url);
    } else {
        echo "Ressource introuvable : " . $http_code;
    }
} catch (\Throwable $th) {
    throw $th;
} finally {
    curl_close($ch);
}
