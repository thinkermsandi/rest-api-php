<?php
namespace Api\Exception;

/**
 * A class to implement errors resulting from a resource that has been removed
 * 
 * eg. 
 */
class HttpGoneException extends BaseException{
    
    public function __construct() {
        parent::__construct(410, 'The resource is no longer available');
    }
    
}
