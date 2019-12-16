<?php
namespace Api\Exception;

/**
 * A class to implement errors resulting from a client trying to access a pay-walled resource
 * 
 * eg. 
 */
class HttpPaymentRequiredException extends BaseException{
    
    public function __construct() {
        parent::__construct(402, 'Payment Required');
    }
    
}
