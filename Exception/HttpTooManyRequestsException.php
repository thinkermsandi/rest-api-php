<?php
namespace Api\Exception;

/**
 * A class to implement errors resulting from a client sending too many requests in a given time
 * 
 * eg. 
 */
class HttpTooManyRequestsException extends BaseException{
    
    public function __construct() {
        parent::__construct(429, 'Too many requests');
    }
    
}
