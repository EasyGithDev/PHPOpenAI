# PHPOpenAI

Welcome to the GitHub project page for "PHPOpenAI", a project that enables the use of the OpinAI API in PHP.

The project is written in PHP and can be used to easily integrate the OpinAI API into your existing PHP project. The OpenAI API provides natural language processing tools for sentiment analysis, text classification, and named entity recognition.

Installation via Git: To install the project, you can clone it from GitHub using the following Git command:

bash

```bash
git clone git@github.com:EasyGithDev/PHPOpenAI.git
```

Using Composer: The project uses Composer to manage dependencies. If you haven't already installed Composer, you can do so by following the instructions on the official Composer website. After installing Composer, you can install the project dependencies by running the following command in the project directory:

`composer install`

Writing a First Example: To use the OpinAI API, you need to sign up on their website and obtain an API key. Once you have your API key, you can use it in your PHP code to send requests to the OpenAI API.

Here's an example code that shows you how to use the OpinAI API in PHP:

php

```php
require_once __DIR__ . '/vendor/autoload.php';

use EasyGithDev\PHPOpenAI\Configuration;
use EasyGithDev\PHPOpenAI\Model;
use EasyGithDev\PHPOpenAI\OpenAIApi;

$configuration = new Configuration($apiKey);
$openAIApi = new OpenAIApi($configuration);
$completion = $openAIApi->Completion();
$response = $completion->create(
    Model::TEXT_DAVINCI_003,
    "Say this is a test",    
);

var_dump($response);
```

In this example, we used the `Completion` class provided by the PHPOpenAI project to send a sentiment analysis request to the OpenAI API using the `create()` method. We passed our API key to the `Configuration` class during instantiation and provided the text we want to analyze.

The result returned by the API is stored in the `$response` variable, which contains the analyzed text. .

PHPOpenAI is a useful project for PHP developers who want to easily integrate the OpenAI API into their projects. With simple installation and the use of Composer, text classification, image generation and named entity recognition into your PHP application.