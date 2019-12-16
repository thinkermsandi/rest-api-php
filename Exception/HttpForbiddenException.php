<?php
namespace Api\Exception;

/**
 * A class to implement errors resulting from a server refusing to perform any action
 * 
 * eg. 
 */
class HttpForbiddenException extends BaseException{
    
    public function __construct() {
        parent::__construct(403, 'You are not permitted to view this resource');
    }
    
}
