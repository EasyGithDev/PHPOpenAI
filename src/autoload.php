<?php

namespace EasyGithDev\PHPOpenAI;

spl_autoload_register(function ($class) {
    include __DIR__ . '/' . $class . '.php';
});
