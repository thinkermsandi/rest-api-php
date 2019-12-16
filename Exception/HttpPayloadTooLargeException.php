<?php
namespace Api\Exception;

/**
 * A class to implement errors resulting from a request that is larger than the server is willing to process
 * eg. 
 */
class HttpPayloadTooLargeException extends BaseException{
    
    public function __construct() {
        parent::__construct(413, 'Request is too large');
    }
    
}
