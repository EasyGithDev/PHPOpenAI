<?php

namespace EasyGithDev\PHPOpenAI;

spl_autoload_register(function ($class) {
    $class = str_replace(__NAMESPACE__, '', $class);
    $class = str_replace('\\', '/', $class);
    include __DIR__ . '/' . $class . '.php';
});
