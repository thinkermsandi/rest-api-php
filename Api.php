<?php

namespace Api;

use Api\Core\Auth;

use Api\Controller\SampleController;

use Api\Exception\HttpBadRequestException;
use Api\Exception\HttpMethodNotAllowedException;

/**
 * The API main class
 */
class Api {
    
    /**
     * Property: request
     * The full HTTP request array
     */
    protected $request = array();
    
     /**
     * Property: method
     * The HTTP method this request was made in, either GET, POST, PUT or DELETE
     */
    protected $method = '';
    
    /**
     * Property: endpoint
     * The Model requested in the URI. eg: /files
     */
    protected $endpoint = '';
    
    /**
     * Property: verb
     * An optional additional descriptor about the endpoint, used for things that can
     * not be handled by the basic methods. eg: /files/process
     */
    protected $verb = '';
    
    /**
     * Property: args
     * Any additional URI components after the endpoint and verb have been removed, in our
     * case, an integer ID for the resource. eg: /<endpoint>/<verb>/<arg0>/<arg1>
     * or /<endpoint>/<arg0>
     */
    protected $args = Array();
    
    /**
     * Property: file
     * Stores the input of the PUT request
     */
     protected $file = Null;
     
     /**
     * Property: user
     * Stores the user object with data specifying the user role and access tokens
     */
     private $user = Null;


     public function __construct($request, $origin) {
        
        header("Access-Control-Allow-Orgin: *");
        header("Access-Control-Allow-Methods: *");
        header("Content-Type: application/json");

        $this->request = $request;
        $this->args = explode('/', rtrim($this->request, '/'));
        $this->endpoint = array_shift($this->args);
        if (array_key_exists(0, $this->args) && !is_numeric($this->args[0])) {
            $this->verb = array_shift($this->args);
        }

        $this->method = $_SERVER['REQUEST_METHOD'];
        if ($this->method == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER)) {
            if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'DELETE') {
                $this->method = 'DELETE';
            }
            else if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT') {
                $this->method = 'PUT';
            }
            else {
                throw new HttpBadRequestException; //Unexpected header
            }
        }
        
        $this->getArguments();
        
        //TODO: Authenticate the user here
        //$this->user = AuthController::getUser($this->request);
        
    }
    
    private function getArguments(){
        switch($this->method) {
            case 'DELETE':
                $this->request = $_POST;
                
            case 'POST':
                $this->request = $_POST;
                $this->file = $_FILES;
                break;
            
            case 'GET':
                $this->request = $_GET;
                break;
            
            case 'PUT':
                $this->request = $_POST;
                $this->file = $_FILES;
                break;
            
            default:
                throw new HttpMethodNotAllowedException;
        }
    }

    public function processAPI() {
        if (method_exists($this, $this->endpoint)) {
            $this->{$this->endpoint}();
        }
        else{
            throw new HttpBadRequestException;
        }
    }
    
    protected function samples(){
        $controller = new SampleController($this->user);
        
        if($this->method == 'POST'){
            if(empty($this->verb) && empty($this->args)){
                /*
                *  /samples
                */
                $controller->samples($this->request); //--Done
            }
            else if(!empty($this->verb) && $this->verb == 'sample' && !empty($this->args[0])){
                if(empty($this->args[1]) && is_numeric($this->args[0])){
                    /*
                    *  /sample/sample/id
                    */
                    $controller->sample($this->args[0]); //--Done
                }
                else if(empty($this->args[1]) && $this->args[0] == 'new'){
                    /*
                    *  /sample/sample/new 
                    */
                    $controller->insertSample($this->request); // --Done
                }
                else if(is_numeric($this->args[0]) && empty($this->args[2])){
                    if($this->args[1] == 'update'){
                        /*
                        *  /sample/sample/id/update
                        */
                        $controller->updateSample($this->args[0], $this->request); // --Done
                    }
                    else if($this->args[1] == 'remove'){
                        /*
                        *  /sample/sample/id/remove
                        */
                        $controller->deleteSample($this->args[0], $this->request); // --Done
                    }
                }
            }
            
            throw new HttpBadRequestException;
        }
        
        else{
            throw new HttpMethodNotAllowedException;
        }
    }
    
}
