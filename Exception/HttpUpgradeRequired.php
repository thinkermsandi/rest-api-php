<?php
namespace Api\Exception;

/**
 * A class to implement errors resulting from a client using a different protocol and has to upgrade
 * 
 * eg. 
 */
class HttpUpgradeRequired extends BaseException{
    
    public function __construct() {
        parent::__construct(426, 'Upgrade to a new API version');
    }
    
}
