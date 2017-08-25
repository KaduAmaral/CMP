<?php

spl_autoload_register(function ($class_name) {
   include_once $class_name . '.php';
});


$cmd = new \CMP\Console;

$cmd->register('hello', new \tests\HelloWorldCommand());

$cmd->run();