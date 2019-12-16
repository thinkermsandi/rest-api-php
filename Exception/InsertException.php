<?php

namespace Api\Exception;

/**
 * A class to handle HTTP INSERT resource errors 
 */
class InsertException extends BaseException{
    
    public function __construct() {
        parent::__construct(421, 'Error creating resource');
    }
    
}
