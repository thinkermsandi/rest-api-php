<?php

namespace Api\Exception;

/**
 * A class to handle HTTP UPDATE resource errors 
 */
class UpdateException extends BaseException{
    
    public function __construct() {
        parent::__construct(422, 'Error updating resource');
    }
    
}
