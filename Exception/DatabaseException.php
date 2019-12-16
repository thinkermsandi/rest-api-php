<?php
namespace Api\Exception;

/**
 * A class to handle all database errors
 */
class DatabaseException extends BaseException{
    
    public function __construct() {
        parent::__construct(500, 'Database error');
    }
    
}
