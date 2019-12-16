<?php

namespace Api\Util;

/**
 * Utility class
 */
class Utils {
    
    /**
     * Function to generate a unique token of aplhanumeric characters
     * 
     * @param type $length
     * 
     * @return type
     */
    public static function random_token($length = 5){
        if (function_exists('random_bytes')) {
            return bin2hex(random_bytes($length));
        }
        if (function_exists('openssl_random_pseudo_bytes')) {
            return bin2hex(openssl_random_pseudo_bytes($length));
        }
       //Deprecated in PHP 7
        if (function_exists('mcrypt_create_iv')) {
            return bin2hex(mcrypt_create_iv($length, MCRYPT_DEV_URANDOM));
        }
    }
    
    /**
     * Function to generate a unique token of numeric characters
     * 
     * @param type $length
     * 
     * @return integer
     */
    public static function random_numbers($length = 4){
        return random_int(1000, 9999);
    }
    
    /**
     * Function to generate a hash value from password aplhanumeric characters
     * 
     * @param type $password
     * 
     * @return string
     */
    public static function passwordHash($password){
        return password_hash($password, PASSWORD_DEFAULT);
    }
    
    /**
     * Function to verify if the given password matches the hash value
     * 
     * @param type $password
     * @param type $hash
     * 
     * @return boolean true if the password matches
     */
    public static function passwordVerify($password, $hash){
        return password_verify($password, $hash);
    }
    
    /**
     * Function to generate the start and limit values for LIMIT sql queries
     * 
     * @param int $page
     * @param type $results_per_page
     * 
     * @return array
     */
    public static function databaseLimitParams($page, $results_per_page){
        if(empty($page)){
            $page = 0;
        }
        
        $count = $results_per_page;
        
        $start = $page * $results_per_page;
        
        return array('start' => $start, 'count' => $count);
    }
    
}
