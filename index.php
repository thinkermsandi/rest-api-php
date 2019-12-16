<?php

    namespace Api;
    
    error_reporting(0);
    
    //error_reporting(E_ALL);
    //ini_set('display_errors', 1);
    //ini_set('log_errors', TRUE); // Error logging
    //ini_set('error_log', 'errors.log'); // Logging file
    //ini_set('log_errors_max_len', 1024); // Logging file size

    use Api\Api;
    
    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php');

    // Requests from the same server don't have a HTTP_ORIGIN header
    if (!array_key_exists('HTTP_ORIGIN', $_SERVER)) {
        $_SERVER['HTTP_ORIGIN'] = $_SERVER['SERVER_NAME'];
    }
    
    $api = new Api($_REQUEST['request'], $_SERVER['HTTP_ORIGIN']);
    $api->processAPI();