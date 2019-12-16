<?php

namespace Api\Model;

use Api\Core\Constants;

/**
 * A class which holds current user account information
 */
class User {
    
    private $id;
    private $role;
    
    public function __construct() {
        $this->id = 0;
        $this->role = Constants::$_USER_ACCOUNT_TYPE_GUEST;
    }
    

    public function setId($id) {
        $this->id = $id;
    }
    
    public function setRole($role) {
        $this->role = $role;
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function getRole(){
        return $this->role;
    }
    
}
