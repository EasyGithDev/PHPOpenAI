# PHPOpenAI

Welcome to the GitHub project page for "PHPOpenAI", a project that enables the use of the OpenAI API in PHP.

The project is written in PHP and can be used to easily integrate the OpenAI API into your existing PHP project. The OpenAI API provides natural language processing tools for text classification, image generation and named entity recognition.

## System Requirements

- PHP 8.1
- CURL

## Installation via Git

To install the project, you can clone it from GitHub using the following Git command:

```bash
git clone git@github.com:EasyGithDev/PHPOpenAI.git
```

## Using Composer

The project uses Composer to manage dependencies. If you haven't already installed Composer, you can do so by following the instructions on the official Composer website. After installing Composer, you can install the project dependencies by running the following command in the project directory:

```bash
composer install
```

## Writing a First Example

To use the OpenAI API, you need to sign up on their website and obtain an API key. Once you have your API key, you can use it in your PHP code to send requests to the OpenAI API.

Here's an example code that shows you how to use the OpenAI API in PHP:

```php
<?php
require_once __DIR__ . '/vendor/autoload.php';

use EasyGithDev\PHPOpenAI\Configuration;
use EasyGithDev\PHPOpenAI\Model;
use EasyGithDev\PHPOpenAI\OpenAIApi;

$apiKey = "XXXXXXX YOUR KEY";
if (file_exists(Configuration::$_configDir . '/key.php')) {
    $apiKey = require Configuration::$_configDir . '/key.php';
}

$configuration = new Configuration($apiKey);
$openAIApi = new OpenAIApi($configuration);
$completion = $openAIApi->Completion();
$response = $completion->create(
    Model::TEXT_DAVINCI_003,
    "Say this is a test",    
);

var_dump($response);
```

This code instantiates a new `OpenAIApi` object with an API key, and then creates a new `Completion` object to perform text completion with the GPT-3 AI language model provided by OpenAI.

You can create a file containing the api key. It will be necessary to place the file in the folder named config.

```php
<?php
return "YOUR KEY";
```

This code instantiates a new `OpenAIApi` object with an API key, and then creates a new `Completion` object to perform text completion with the GPT-3 AI language model provided by OpenAI.

You can create a file containing the api key. It will be necessary to place the file in the folder named config.


The `create()` method is called on the `Completion` object to generate a new text completion. It takes two parameters:

- the first parameter is the ID of the GPT-3 model to use for completion. In this case, it uses the TEXT_DAVINCI_003 model.
- the second parameter is the prompt or input text for which the completion will be generated. In this case, the prompt is "Say this is a test".

The result of the completion is returned in the `$response` variable. The result can then be used for further processing, such as displaying the completed text or feeding it into another part of the program for additional processing.

Obviously you can use a short syntax.

```php
<?php
require_once __DIR__ . '/vendor/autoload.php';

use EasyGithDev\PHPOpenAI\Model;
use EasyGithDev\PHPOpenAI\OpenAIApi;

$response = (new OpenAIApi("YOUR KEY"))->Completion()->create(
    Model::TEXT_DAVINCI_003,
    "Say this is a test",
);
```

## Examples

Integrating OpenAI into your application is now as simple as a few lines of code.

### Text Completion using ChatGPT

```php
$response = (new OpenAIApi($apiKey))->Chat()->create(
    Model::GPT_3_5_TURBO,
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
    Model::TEXT_DAVINCI_003,
    "Say this is a test",
);
```

[Learn more about text completion](https://platform.openai.com/docs/guides/completion).

### Text Edit

```php
$response = (new OpenAIApi($apiKey))->Edit()->create(
    input: "What day of the wek is it?",
    instruction: "Fix the spelling mistakes",
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
$response = (new OpenAIApi($apiKey))->ImageVariation()->createVariation(
    __DIR__ . '/../../assets/image_variation_original.png',
    n: 2,
    size: ImageSize::is256
);
```

[Learn more about image variation](https://platform.openai.com/docs/guides/images/variations).

### Image Edit Using DALL·E

```php
$response = (new OpenAIApi($apiKey))->ImageEdit()->createEdit(
    image: __DIR__ . '/../../assets/image_edit_original.png',
    mask: __DIR__ . '/../../assets/image_edit_mask2.png',
    prompt: 'a sunlit indoor lounge area with a pool containing a flamingo',
    size: ImageSize::is512,
);
```

[Learn more about image edit](https://platform.openai.com/docs/guides/images/edits).

### Audio Transcription (Speech to text) using Whisper

```php
$response = (new OpenAIApi($apiKey))->Audio()->transcription(
    __DIR__ . '/../../assets/openai.mp3',
    Model::WHISPER_1,
    responseFormat: ResponseFormat::SRT
);
```

[Learn more about speech to text](https://platform.openai.com/docs/guides/speech-to-text).

### Audio Translation (Speech to text) using Whisper

```php
$response = (new OpenAIApi($apiKey))->Audio()->translation(
    __DIR__ . '/../../assets/openai_fr.mp3',
    Model::WHISPER_1,
    responseFormat: ResponseFormat::TEXT
);
```

[Learn more about speech to text](https://platform.openai.com/docs/guides/speech-to-text/translations).


### Errors



### Summary

PHPOpenAI is a useful project for PHP developers who want to easily integrate the OpenAI API into their projects. With simple installation and the use of Composer, text classification, image generation and named entity recognition into your PHP application.