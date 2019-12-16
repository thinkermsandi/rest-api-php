<?php
namespace Api\Exception;

use Api\Core\Response;

/**
 * Base exception class
 * 
 * Extended by all Error handlers
 */
class BaseException{
    
    public function __construct($code, $details) {
        $data = array('result' => 'error', 'code' => $code, 'details' => $details);
        Response::json($data);
    }
    
}
