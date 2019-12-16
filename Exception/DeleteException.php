<?php
namespace Api\Exception;

/**
 * A class to handle HTTP DELETE resource errors 
 */
class DeleteException extends BaseException{
    
    public function __construct() {
        parent::__construct(420, 'Error removing resource');
    }
    
}
