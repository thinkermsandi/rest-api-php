<?php
namespace Api\Exception;

/**
 * A class to implement errors when authentication is required and has failed
 * 
 * eg. 
 */
class HttpUnauthorizedException extends BaseException{
    
    public function __construct() {
        parent::__construct(401, 'Authorization Error');
    }
    
}
