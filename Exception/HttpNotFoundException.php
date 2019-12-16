<?php
namespace Api\Exception;

/**
 * A class to implement errors resulting from a resource that cannot be found
 * 
 * eg. 
 */
class HttpNotFoundException extends BaseException{
    
    public function __construct() {
        parent::__construct(404, 'Resource Not Found');
    }
    
}
