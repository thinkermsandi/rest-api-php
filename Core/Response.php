<?php
namespace Api\Core;

/**
 * Class to send responses back to the client
 */
class Response {
    
    public static function json($data = array(), $sendAsObject = false) {
        header("Content-Type: application/json");
        
        if($sendAsObject){
            echo json_encode($data, JSON_FORCE_OBJECT);
        }
        else{
            echo json_encode($data);
        }
        die();
    }
    
}
