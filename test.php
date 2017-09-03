<?php
include './vendor/autoload.php';
//*
spl_autoload_register(function ($class_name) {
   $file = str_replace('\\', '/', $class_name);
   $filepath = __DIR__.DIRECTORY_SEPARATOR.$file;
   include_once $filepath . '.php';
});


$cmd = new \CMP\Console;

$cmd->register('hello', new \tests\HelloWorldCommand());

$cmd->run();