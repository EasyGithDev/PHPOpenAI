# PHPOpenAI

Welcome to the GitHub project page for "PHPOpenAI", a project that enables the use of the OpinAI API in PHP.

The project is written in PHP and can be used to easily integrate the OpinAI API into your existing PHP project. The OpenAI API provides natural language processing tools for text classification, image generation and named entity recognition.

### Installation via Git

To install the project, you can clone it from GitHub using the following Git command:

```bash
git clone git@github.com:EasyGithDev/PHPOpenAI.git
```

### Using Composer

The project uses Composer to manage dependencies. If you haven't already installed Composer, you can do so by following the instructions on the official Composer website. After installing Composer, you can install the project dependencies by running the following command in the project directory:

```bash
composer install
```

### Writing a First Example

To use the OpinAI API, you need to sign up on their website and obtain an API key. Once you have your API key, you can use it in your PHP code to send requests to the OpenAI API.

Here's an example code that shows you how to use the OpinAI API in PHP:

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

The `create()` method is called on the `Completion` object to generate a new text completion. It takes two parameters:

- the first parameter is the ID of the GPT-3 model to use for completion. In this case, it uses the TEXT_DAVINCI_003 model.
- the second parameter is the prompt or input text for which the completion will be generated. In this case, the prompt is "Say this is a test".

The result of the completion is returned in the `$response` variable. The result can then be used for further processing, such as displaying the completed text or feeding it into another part of the program for additional processing.

### Summary

PHPOpenAI is a useful project for PHP developers who want to easily integrate the OpenAI API into their projects. With simple installation and the use of Composer, text classification, image generation and named entity recognition into your PHP application.