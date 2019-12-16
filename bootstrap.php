<?php

    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'lib/vendor/autoload.php'); //Composer autoloader
    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'autoload.php'); //Our App autoloader

    //Load environment vars
    $dotenv = new Dotenv\Dotenv(__DIR__);
    $dotenv->load();