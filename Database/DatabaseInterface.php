<?php
namespace Api\Database;

/**
 * An Interface to be implemented by all database handlers
 */
interface DatabaseInterface {

    public static function getInstance();
    
    public function connection();
    
    public function query($sql);
    
}
