# PHPOpenAI

`PHPOpenAI` is a community-maintained library that enables the use of the `OpenAI` API in PHP.

The project is written in PHP and can be used to easily integrate the `OpenAI API` into your existing PHP project.

## System Requirements

This project is based on PHP version 8.1 in order to use features such as enumerations. This project does not require any external dependencies. However, you must have the cURL extension installed for it to work properly.

- PHP version >= 8.1
- cURL extension

## Installation

The project uses Composer to manage dependencies. If you haven't already installed Composer, you can do so by following the instructions on the official Composer website.

### Packagist install

To install the project, you can install the package from packagist.org using the following command:

```bash
composer require easygithdev/php-openai
```

## Writing a first example

To use the `OpenAI API`, you need to sign up on their website and obtain an API key. Once you have your API key, you can use it in your PHP code to send requests to the OpenAI API.

To find out how to get your key, go to the following address:

[https://help.openai.com/en/articles/4936850-where-do-i-find-my-secret-api-key](https://help.openai.com/en/articles/4936850-where-do-i-find-my-secret-api-key).


Here's an example code that shows you how to use the OpenAI API in PHP:

```php
<?php
require_once __DIR__ . '/vendor/autoload.php';

use EasyGithDev\PHPOpenAI\Helpers\ModelEnum;
use EasyGithDev\PHPOpenAI\OpenAIClient;

$apiKey = getenv('OPENAI_API_KEY');

$response = (new OpenAIClient($apiKey))->Completion()->create(
    ModelEnum::TEXT_DAVINCI_003,
    "Say this is a test",
)->toObject();

// Response as stClass object
echo '<pre>', print_r($response, true), '</pre>';
```

This code instantiates a new `OpenAIApi` object with an API key, and then creates a new `Completion` object to perform text completion with the GPT-3 AI language model provided by OpenAI.

The `create()` method is called on the `Completion` object to generate a new text completion. It takes two parameters:

- the first parameter is the ID of the GPT-3 model to use for completion. In this case, it uses the TEXT_DAVINCI_003 model.
- the second parameter is the prompt or input text for which the completion will be generated. In this case, the prompt is "Say this is a test".

The result of the completion is returned in the `$response` variable. The result can then be used for further processing, such as displaying the completed text or feeding it into another part of the program for additional processing.


## Manage the API Key

You can use an environment variable to store your key. You can then use this variable as in the following example:

```bash
export OPENAI_API_KEY="sk-xxxxxxxxxxx"
```

You can put the variable in Apache configuration file  :

```
<VirtualHost hostname:80>
   ...
   SetEnv OPENAI_API_KEY sk-xxxxxxxxxxx
   ...
</VirtualHost>
```

And then restart the service.

Now, you can use the environment variable by calling the `getenv()` function of PHP.

```php
<?php
$response = (new OpenAIApi(getenv('OPENAI_API_KEY')))->Completion()->create(
    ModelEnum::TEXT_DAVINCI_003,
    "Say this is a test",
);
```

## Manage the organization

If you wish to provide information about your organization, you must proceed as follows.

```php
<?php
$apiKey = getenv('OPENAI_API_KEY');
$org = getenv('MY_ORG');

// Create a new configuration object
// with the key and the organization
$config = new OpenAIConfiguration($apiKey, $org);

// Passing the configuration to the client
$client = new OpenAIClient($config);
```

## Manage the API's Url

If you need to modify the API's URL, you can proceed as follows:

```php
<?php
$apiKey = getenv('OPENAI_API_KEY');

// Create a new router, with origine url and version
$route = new OpenAIRoute(
    'https://api.openai.com',
    'v1'
);

// Passing the router to the client
$client = new OpenAIClient($apiKey, $route);
```

To redefine a route, you need to extend the `OpenAIRoute` class or implement the `Route` interface.

## Manage the reponses

The API returns responses in JSON format. To facilitate access to the different information, you can call `toObject()` or `toArray()` methods  of the Handler object to access the data.

```php
<?php

$response = (new OpenAIClient($apiKey))->Completion()->create(
    ModelEnum::TEXT_DAVINCI_003,
    "Say this is a test",
)->toObject();

// Response as a stClass object
echo '<pre>', print_r($response, true), '</pre>';

$response = (new OpenAIClient($apiKey))->Completion()->create(
    ModelEnum::TEXT_DAVINCI_003,
    "Say this is a test",
)->toArray();

// Response as an associative array
echo '<pre>', print_r($response, true), '</pre>';
```

## Manage the errors

Sometimes, the API returns errors. Therefore, it is necessary to be able to identify what caused the problem. To handle this difficulty, you have many options. 

If you are using a Handler object with `toObject()` or `toArray()` methods, just use a `try-catch` structure.

```php
try {
    $response = (new OpenAIClient('BAD KEY'))
        ->Completion()
        ->create(
            ModelEnum::TEXT_DAVINCI_003,
            "Say this is a test",
        )
        ->toObject();
} catch (Throwable $t) {
    echo nl2br($t->getMessage());
    die;
}
```

If you are using the `CurlResponse` object, you can check that an error has occurred using the validators. 

```php

$handler = (new OpenAIClient('BAD KEY'))->Completion()->create(
    ModelEnum::TEXT_DAVINCI_003,
    "Say this is a test",
);

$response = $handler->getResponse();
$contentTypeValidator = $handler->getContentTypeValidator();

if (!(new StatusValidator($response))->validate() or 
    !(new $contentTypeValidator($response))->validate()) {
    echo $response->getBody();
}
```

[Learn more about errors](https://platform.openai.com/docs/guides/error-codes/api-errors).

## An example of application 

Here is a video showing an application that allows you to create images with a painting style defined by the user. 
This application is created using the PHPOpenAI project.


<p>

https://user-images.githubusercontent.com/3519890/230593418-22f26562-e88c-4a92-9601-93bb671a16c0.mp4

</p>

You can find the code here:

[https://github.com/EasyGithDev/PHPOpenAI-Playground.git](https://github.com/EasyGithDev/PHPOpenAI-Playground.git).


## Code samples

Integrating OpenAI into your application is now as simple as a few lines of code.

You can find all codes here:

[https://github.com/EasyGithDev/PHPOpenAI-Examples](https://github.com/EasyGithDev/PHPOpenAI-Examples).

### Text Completion using ChatGPT

```php
$response = (new OpenAIClient($apiKey))->Chat()->create(
    ModelEnum::GPT_3_5_TURBO,
    [
        new ChatMessage(ChatMessage::ROLE_SYSTEM, "You are a helpful assistant."),
        new ChatMessage(ChatMessage::ROLE_USER, "Who won the world series in 2020?"),
        new ChatMessage(ChatMessage::ROLE_ASSISTANT, "The Los Angeles Dodgers won the World Series in 2020."),
        new ChatMessage(ChatMessage::ROLE_USER, "Where was it played?"),
    ]
)->toObject();
```

[Learn more about chat completion](https://platform.openai.com/docs/guides/chat).

### Text Completion using GPT-3

```php
$response = (new OpenAIClient($apiKey))->Completion()->create(
    ModelEnum::TEXT_DAVINCI_003,
    "Say this is a test",
)->toObject();
```

[Learn more about text completion](https://platform.openai.com/docs/guides/completion).

### Text Completion using stream

The stream attribute in the OpenAI API is an optional parameter that you can use to control the data flow returned by the API. If you set this option to True, the API will return a response as a streaming data rather than a single response.

This means that you can retrieve the results of the API as they become available, rather than waiting for the complete response before processing them. This option can be useful for applications that require real-time processing of large amounts of data.


<p>

https://user-images.githubusercontent.com/3519890/229144053-d32e6416-0980-44ea-97b7-b2d4a2d26a5d.mp4

</p>


```php
<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

...

(new OpenAIClient($apiKey))->Completion()->create(
    model: "text-davinci-003",
    prompt: "Translate this into 1. French, 2. Spanish and 3. Japanese:\n\nWhat rooms do you have available?\n\n1.",
    temperature: 0.3,
    max_tokens: 100,
    top_p: 1.0,
    frequency_penalty: 0.0,
    presence_penalty: 0.0,
    stream: true
)->getResponse();
```

```html
<html>

<body>
    <div id="result"></div>
    <script>
        function nl2br(str, replaceMode, isXhtml) {
            var breakTag = (isXhtml) ? '<br />' : '<br>';
            var replaceStr = (replaceMode) ? '$1' + breakTag : '$1' + breakTag + '$2';
            return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, replaceStr);
        }

        if (typeof (EventSource) !== 'undefined') {
            console.info('Starting connection...');
            var source = new EventSource('stream.php');
            source.addEventListener('open', function (e) {
                console.info('Connection was opened.');
            }, false);

            source.addEventListener('error', function (e) {
                var txt;
                switch (event.target.readyState) {
                    // if reconnecting
                    case EventSource.CONNECTING:
                        txt = 'Reconnecting...';
                        break;
                    // if error was fatal
                    case EventSource.CLOSED:
                        txt = 'Connection failed. Will not retry.';
                        break;
                }
                console.error('Connection error: ' + txt);
            }, false);

            source.addEventListener('message', function (e) {
                if (e.data == "[DONE]") {
                    source.close();
                    return;
                }
                document.getElementById('result').innerHTML += nl2br(JSON.parse(e.data).choices[0].text);

            }, false);
        } else {
            alert('Your browser does not support Server-sent events! Please upgrade it!');
            console.error('Connection aborted');
        }
    </script>
</body>

</html>
```

### Text Edit

```php
$response = (new OpenAIClient($apiKey))->Edit()->create(
    "What day of the wek is it?",
    ModelEnum::TEXT_DAVINCI_EDIT_001,
    "Fix the spelling mistakes",
)->toObject();
```

[Learn more about text edit](https://platform.openai.com/docs/guides/code/editing-code).

### Image Generation Using DALL·E

```php
function displayUrl($url)
{
    return '<img src="' . $url . '" />';
}

$response = (new OpenAIClient($apiKey))->Image()->create(
    "a rabbit inside a beautiful garden, 32 bit isometric",
    n: 2,
    size: ImageSizeEnum::is256,
)->toObject();
```

```html
<?php foreach ($response->data as $image) : ?>
    <div> <?= displayUrl($image->url) ?> </div>
<?php endforeach; ?>
```

![rabit-32bits](https://user-images.githubusercontent.com/3519890/229202939-4d9290cb-e1fe-4860-b6d6-14bf41d5322b.png)



[Learn more about image generation](https://platform.openai.com/docs/guides/images).

### Image Variation Using DALL·E

```php
 $response = (new OpenAIClient($apiKey))->Image()->createVariation(
        __DIR__ . '/../../assets/image_variation_original.png',
        n: 2,
        size: ImageSizeEnum::is256
    )->toObject();
```

![variation-1](https://user-images.githubusercontent.com/3519890/229203659-0c61bb77-c19e-4840-ad4d-6b22f0179260.png)


[Learn more about image variation](https://platform.openai.com/docs/guides/images/variations).

### Image Edit Using DALL·E

```php
 $response = (new OpenAIClient($apiKey))->Image()->createEdit(
        image: __DIR__ . '/../../assets/image_edit_original.png',
        mask: __DIR__ . '/../../assets/image_edit_mask2.png',
        prompt: 'a sunlit indoor lounge area with a pool containing a flamingo',
        size: ImageSizeEnum::is512,
    )->toObject();
```

![img-edit](https://user-images.githubusercontent.com/3519890/229203979-baf001e9-f72d-4741-a1c8-e8fa48c8c8e3.png)


[Learn more about image edit](https://platform.openai.com/docs/guides/images/edits).

### Embedding

```php
$response = (new OpenAIClient($apiKey))->Embedding()->create(
    ModelEnum::TEXT_EMBEDDING_ADA_002,
    "The food was delicious and the waiter...",
)->toObject();
```

[Learn more about embedding](https://platform.openai.com/docs/guides/embeddings).

### Audio Transcription (Speech to text) using Whisper

```php
$response = (new OpenAIClient($apiKey))->Audio()
    ->addCurlParam('timeout', 30)
    ->transcription(
        __DIR__ . '/../../assets/openai.mp3',
        ModelEnum::WHISPER_1,
        response_format: AudioResponseEnum::SRT
    )->toObject();
```

[Learn more about audio transcription](https://platform.openai.com/docs/guides/speech-to-text).

### Audio Translation (Speech to text) using Whisper

```php
$response = (new OpenAIClient($apiKey))->Audio()
    ->addCurlParam('timeout', 30)
    ->translation(
        __DIR__ . '/../../assets/openai_fr.mp3',
        'whisper-1',
        response_format: AudioResponseEnum::TEXT
    )->toObject();
```

[Learn more about audio translation](https://platform.openai.com/docs/guides/speech-to-text/translations).

### Model List

```php
$response = (new OpenAIClient($apiKey))
    ->Model()
    ->list()
    ->toObject();
```

[Learn more about model](https://platform.openai.com/docs/api-reference/models).

### Model Retrieve

```php
$response = (new OpenAIClient($apiKey))
    ->Model()
    ->retrieve('text-davinci-001')
    ->toObject();
```

[Learn more about model](https://platform.openai.com/docs/api-reference/models/retrieve).

### Model Delete

```php
$response = (new OpenAIClient($apiKey))
    ->Model()
    ->delete(
        $_POST['model']
    )->toObject();
```

[Learn more about model](https://platform.openai.com/docs/api-reference/fine-tunes/delete-model).


### File List

```php
$response = (new OpenAIApi($apiKey))
    ->File()
    ->list()
    ->toObject();
```

[Learn more about file](https://platform.openai.com/docs/api-reference/files/list).

### File Upload

```php
$response = (new OpenAIApi($apiKey))
    ->File()
    ->create(
        __DIR__ . '/../../assets/mydata.jsonl',
        'fine-tune',
    )
    ->toObject();
```

[Learn more about file](https://platform.openai.com/docs/api-reference/files/upload).

### File Delete

```php
$response = (new OpenAIApi($apiKey))
    ->File()
    ->delete('file-xxxx')
    ->toObject();
```

[Learn more about file](https://platform.openai.com/docs/api-reference/files/delete).

### File Retrieve

```php
$response = (new OpenAIApi($apiKey))
    ->File()
    ->retrieve('file-xxxx')
    ->toObject();
```

[Learn more about model](https://platform.openai.com/docs/api-reference/files/retrieve).

### File Retrieve Content

```php
$response = (new OpenAIApi($apiKey))
    ->File()
    ->download('file-xxxx')
    ->toObject();
```

[Learn more about model](https://platform.openai.com/docs/api-reference/files/retrieve-content).


### Fine-tune List

```php
$response = (new OpenAIApi($apiKey))
    ->FineTune()
    ->list()
    ->toObject();
```

[Learn more about fine-tune](https://platform.openai.com/docs/api-reference/fine-tunes/list).

### Fine-tune Create

```php
 $response = (new OpenAIApi($apiKey))
        ->FineTune()
        ->create(
            'file-xxxx'
        )
        ->toObject();
```

[Learn more about fine-tune](https://platform.openai.com/docs/api-reference/fine-tunes/create).

### Fine-tune Retrieve

```php
$response = (new OpenAIApi($apiKey))
    ->FineTune()
    ->retrieve('ft-xxx')
    ->toObject();
```

[Learn more about fine-tune](https://platform.openai.com/docs/api-reference/fine-tunes/retrieve).

### Fine-tune List Events

```php
$response = (new OpenAIApi($apiKey))
    ->FineTune()
    ->listEvents('ft-xxx')
    ->toObject();
```

[Learn more about fine-tune](https://platform.openai.com/docs/api-reference/fine-tunes/events).

### Fine-tune Cancel

```php
$response = (new OpenAIApi($apiKey))
    ->FineTune()
    ->Cancel('ft-xxx')
    ->toObject();
```

[Learn more about fine-tune](https://platform.openai.com/docs/api-reference/fine-tunes/cancel).

### Moderation

```php
$response = (new OpenAIClient($apiKey))
    ->Moderation()
    ->create('I want to kill them.')
    ->toObject();
```

[Learn more about moderation](https://platform.openai.com/docs/models/moderation).

## Testing

To run all tests:

```bash
composer test tests
```

To run only one test :

```bash
composer test tests/[NAME]Test.php
```

### Summary

PHPOpenAI is a useful project for PHP developers who want to easily integrate the OpenAI API into their projects. With simple installation and the use of Composer, text classification, image generation and named entity recognition into your PHP application.
