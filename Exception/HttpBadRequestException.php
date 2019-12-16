<?php
namespace Api\Exception;

/**
 * A class to implement errors resulting from a bad request from the client
 * 
 * eg. malformed request syntax, size too large, invalid request message framing, or deceptive request routing 
 */
class HttpBadRequestException extends BaseException{
    
    public function __construct() {
        parent::__construct(400, 'Invalid Request');
    }
    
}
