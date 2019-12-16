<?php

namespace Api\Util;

/**
 * A Class to perform network requests using CURL
 */
class CurlHandler {
    
    public static function get($url, $data = array()) {
        if(!empty($data)){
            $dataEncoded = http_build_query($data);
            $url .= $url . "?" . $dataEncoded;
        }
        
        $ch = curl_init($url);
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($ch); // Execute
        curl_close($ch);
        
        return $result;
    }
    
    public static function post($url, $data = array()) {
        $ch = curl_init($url);
        
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        if(!empty($data)){
            $dataEncoded = http_build_query($data);
            // Tell cURL to send POST request.
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataEncoded);
        }

        $result = curl_exec($ch); // Execute
        curl_close($ch);
        
        return $result;
    }
    
    public static function multipart($url, $data = array()) {
        $headers = array("Content-Type:multipart/form-data");
        
        $ch = curl_init($url);
        
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($ch); // Execute
        curl_close($ch);
        
        if( $errno = curl_errno($ch) ) { 
            return false; 
        }
        else{
            $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $header = substr($result, 0, $header_size);
            $body = substr($result, $header_size);
            
            return $body;
        }
    }
    
}
