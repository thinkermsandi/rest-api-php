<?php
namespace Api\Exception;

/**
 * A class to implement errors resulting from a client trying to access a resource with an incorrect HTTP method
 * 
 * eg. using GET instead of POST to create a resource
 */
class HttpMethodNotAllowedException extends BaseException{
    
    public function __construct() {
        parent::__construct(405, 'Request method is not supported');
    }
    
}
