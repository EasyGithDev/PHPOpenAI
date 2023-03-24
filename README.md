# PHPOpenAI

Welcome to the GitHub project page for "PHPOpenAI", a project that enables the use of the OpenAI API in PHP.

The project is written in PHP and can be used to easily integrate the OpenAI API into your existing PHP project. The OpenAI API provides natural language processing tools for text classification, image generation and named entity recognition.

## System Requirements

This project is based on PHP version 8.1 in order to use features such as enumerations. This project does not require any external dependencies. However, you must have the cURL extension installed for it to work properly.

- PHP version >= 8.1
- cURL extension

## Installation

The project uses Composer to manage dependencies. If you haven't already installed Composer, you can do so by following the instructions on the official Composer website.

### Packagist install

To install the project, you can install the package from packagist.org using the following command:

```bash
composer require easygithdev/phpopenai
```

### Github install

#### Clone the project

To install the project, you can clone it from GitHub using the following Git command:

```bash
git clone git@github.com:EasyGithDev/PHPOpenAI.git
```

#### Install the project

```bash
composer install
```

## Writing a first example

To use the OpenAI API, you need to sign up on their website and obtain an API key. Once you have your API key, you can use it in your PHP code to send requests to the OpenAI API.

Here's an example code that shows you how to use the OpenAI API in PHP:

```php
<?php
require_once __DIR__ . '/vendor/autoload.php';

use EasyGithDev\PHPOpenAI\Models\ModelEnum;
use EasyGithDev\PHPOpenAI\OpenAIApi;

$response = (new OpenAIApi("YOUR_KEY"))->Completion()->create(
    ModelEnum::TEXT_DAVINCI_003,
    "Say this is a test",
);

var_dump($response);
```

This code instantiates a new `OpenAIApi` object with an API key, and then creates a new `Completion` object to perform text completion with the GPT-3 AI language model provided by OpenAI.

The `create()` method is called on the `Completion` object to generate a new text completion. It takes two parameters:

- the first parameter is the ID of the GPT-3 model to use for completion. In this case, it uses the TEXT_DAVINCI_003 model.
- the second parameter is the prompt or input text for which the completion will be generated. In this case, the prompt is "Say this is a test".

The result of the completion is returned in the `$response` variable. The result can then be used for further processing, such as displaying the completed text or feeding it into another part of the program for additional processing.


## Manage the API Key

### First possibility

You can use an environment variable to store your key. You can then use this variable as in the following example:

```bash
export OPENAI_API_KEY="sk-xxxxxxxxxxx"
```

```php
<?php
$response = (new OpenAIApi(getenv('OPENAI_API_KEY')))->Completion()->create(
    ModelEnum::TEXT_DAVINCI_003,
    "Say this is a test",
);
```

### Second possibility

You can create a file containing the key. By default, you should use the folder named "config" to place your file. However, you can modify this behavior as follows:

```php
<?php
Configuration::$_configDir = '/YOUR/PATH/TO/THE/FILE';
```

The contents of the "key.php" file are as follows:

```php
<?php
return 'API_KEY';
```

You can then use this variable as in the following example:

```php
<?php
$apiKey = '';
if (file_exists(Configuration::$_configDir . '/key.php')) {
    $apiKey = require Configuration::$_configDir . '/key.php';
}

$response = (new OpenAIApi($apiKey))->Completion()->create(
    ModelEnum::TEXT_DAVINCI_003,
    "Say this is a test",
);
```

## Manage the reponses

The API returns responses in JSON format. To facilitate access to the different information, this response is encapsulated in an object named CurlResponse. You can then call the different methods of this object to access the data.

```php
<?php
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
```

Methods specific to the CompletionResponse object.

```php
<?php
$response = (new OpenAIApi($apiKey))->Completion()->create(
    ModelEnum::TEXT_DAVINCI_003,
    "Say this is a test",
);

// Get all choices as stClass object
foreach ($response->choices() as $choice) {
    echo '<pre>', print_r($choice, true), '</pre>';
}

// Get one choice as stClass object
echo $response->choice(0)->text;

// Get all text as string array
echo '<pre>', print_r($response->fetchAll(), true), '</pre>';
```

## Manage the errors

Sometimes, the API returns errors. Therefore, it is necessary to be able to identify what caused the problem. To handle this difficulty, you have two options. 

Either you receive the response and check that an error has occurred using the isOk() method. 

```php
$response = (new OpenAIApi('BAD KEY'))->Completion()->create(
    ModelEnum::TEXT_DAVINCI_003,
    "Say this is a test",
);

if (!$response->isOk()) {
    $err = $response->getError();
    echo $err->message, ' ',
    $err->type, ' ',
    $err->param, ' ',
    $err->code;
}
```

Or, you use a try-catch structure by using the throwable() method of the CurlResponse object.

```php
try {
    $response = (new OpenAIApi('BAD KEY'))->Completion()->create(
        ModelEnum::TEXT_DAVINCI_003,
        "Say this is a test",
    )->throwable();
} catch (ApiException $e) {
    echo nl2br($e->getMessage());
    die;
}
```

[Learn more about errors](https://platform.openai.com/docs/guides/error-codes/api-errors).

## Examples

Integrating OpenAI into your application is now as simple as a few lines of code.

You can find all the examples in the folder named "examples".

### Text Completion using ChatGPT

```php
$response = (new OpenAIApi($apiKey))->Chat()->create(
    ModelEnum::GPT_3_5_TURBO,
    [
        new Message(Message::ROLE_SYSTEM, "You are a helpful assistant."),
        new Message(Message::ROLE_USER, "Who won the world series in 2020?"),
        new Message(Message::ROLE_ASSISTANT, "The Los Angeles Dodgers won the World Series in 2020."),
        new Message(Message::ROLE_USER, "Where was it played?"),
    ]
);
```

[Learn more about chat completion](https://platform.openai.com/docs/guides/chat).

### Text Completion using GPT-3

```php
$response = (new OpenAIApi($apiKey))->Completion()->create(
    ModelEnum::TEXT_DAVINCI_003,
    "Say this is a test",
);
```

[Learn more about text completion](https://platform.openai.com/docs/guides/completion).

### Text Edit

```php
$response = (new OpenAIApi($apiKey))->Edit()->create(
    "What day of the wek is it?",
    ModelEnum::TEXT_DAVINCI_EDIT_001,
    "Fix the spelling mistakes",
);
```

[Learn more about text edit](https://platform.openai.com/docs/guides/code/editing-code).

### Image Generation Using DALL·E

```php
$response = (new OpenAIApi($apiKey))->Image()->create(
    "a rabbit inside a beautiful garden, 32 bit isometric",
    n:4,
    size: ImageSize::is256,
);

```

[Learn more about image generation](https://platform.openai.com/docs/guides/images).

### Image Variation Using DALL·E

```php
$response = (new OpenAIApi($apiKey))->Image()->createVariation(
    __DIR__ . '/../../assets/image_variation_original.png',
    n: 2,
    size: ImageSize::is256
);
```

[Learn more about image variation](https://platform.openai.com/docs/guides/images/variations).

### Image Edit Using DALL·E

```php
$response = (new OpenAIApi($apiKey))->Image()->createEdit(
    image: __DIR__ . '/../../assets/image_edit_original.png',
    mask: __DIR__ . '/../../assets/image_edit_mask2.png',
    prompt: 'a sunlit indoor lounge area with a pool containing a flamingo',
    size: ImageSize::is512,
);
```

[Learn more about image edit](https://platform.openai.com/docs/guides/images/edits).

### Embedding

```php
$response = (new OpenAIApi($apiKey))->Embedding()->create(
    ModelEnum::TEXT_EMBEDDING_ADA_002,
    "The food was delicious and the waiter...",
);
```

[Learn more about embedding](https://platform.openai.com/docs/guides/embeddings).

### Audio Transcription (Speech to text) using Whisper

```php
$response = (new OpenAIApi($apiKey))->Audio()->transcription(
    __DIR__ . '/../../assets/openai.mp3',
    ModelEnum::WHISPER_1,
    responseFormat: ResponseFormat::SRT
);
```

[Learn more about audio transcription](https://platform.openai.com/docs/guides/speech-to-text).

### Audio Translation (Speech to text) using Whisper

```php
$response = (new OpenAIApi($apiKey))->Audio()->translation(
    __DIR__ . '/../../assets/openai_fr.mp3',
    ModelEnum::WHISPER_1,
    responseFormat: ResponseFormat::TEXT
);
```

[Learn more about audio translation](https://platform.openai.com/docs/guides/speech-to-text/translations).

### Model List

```php
$response = (new OpenAIApi($apiKey))
    ->Model()
    ->list();
```

[Learn more about model](https://platform.openai.com/docs/api-reference/models).

### Model Retrieve

```php
$response = (new OpenAIApi($apiKey))
        ->Model()
        ->retrieve('text-davinci-001');
```

[Learn more about model](https://platform.openai.com/docs/api-reference/models/retrieve).

### Model Delete

```php
$response = (new OpenAIApi($apiKey))
        ->Model()
        ->delete('your own model');
```

[Learn more about model](https://platform.openai.com/docs/api-reference/fine-tunes/delete-model).


### File List

```php
$response = (new OpenAIApi($apiKey))
    ->File()
    ->list();
```

[Learn more about file](https://platform.openai.com/docs/api-reference/files/list).

### File Upload

```php
$response = (new OpenAIApi($apiKey))
    ->File()
    ->create(
        __DIR__ . '/../../assets/mydata.jsonl',
        'fine-tune',
    );
```

[Learn more about file](https://platform.openai.com/docs/api-reference/files/upload).

### File Delete

```php
$response = (new OpenAIApi($apiKey))
    ->File()
    ->delete('file-xxxx');
```

[Learn more about file](https://platform.openai.com/docs/api-reference/files/delete).

### File Retrieve

```php
$response = (new OpenAIApi($apiKey))
    ->File()
    ->retrieve('file-xxxx');
```

[Learn more about model](https://platform.openai.com/docs/api-reference/files/retrieve).

### File Retrieve Content

```php
$response = (new OpenAIApi($apiKey))
    ->File()
    ->download('file-xxxx');
```

[Learn more about model](https://platform.openai.com/docs/api-reference/files/retrieve-content).


### Fine-tune List

```php
$response = (new OpenAIApi($apiKey))
    ->FineTune()
    ->list();
```

[Learn more about fine-tune](https://platform.openai.com/docs/api-reference/fine-tunes/list).

### Fine-tune Create

```php
 $response = (new OpenAIApi($apiKey))
        ->FineTune()
        ->create(
            'file-xxxx'
        );
```

[Learn more about fine-tune](https://platform.openai.com/docs/api-reference/fine-tunes/create).

### Fine-tune Retrieve

```php
$response = (new OpenAIApi($apiKey))
    ->FineTune()
    ->retrieve('ft-xxx');
```

[Learn more about fine-tune](https://platform.openai.com/docs/api-reference/fine-tunes/retrieve).

### Fine-tune List Events

```php
$response = (new OpenAIApi($apiKey))
    ->FineTune()
    ->listEvents('ft-xxx');
```

[Learn more about fine-tune](https://platform.openai.com/docs/api-reference/fine-tunes/events).

### Fine-tune Cancel

```php
$response = (new OpenAIApi($apiKey))
    ->FineTune()
    ->Cancel('ft-xxx');
```

[Learn more about fine-tune](https://platform.openai.com/docs/api-reference/fine-tunes/cancel).

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