<?php
namespace Api\Database;

use Api\Database\DatabaseInterface;
use Api\Exception\DatabaseException;

use Pixie\Connection;
use Pixie\QueryBuilder\QueryBuilderHandler;

/**
 * A class to perform database operations using MySQL
 */
class Mysql implements DatabaseInterface{
    
    private static $instance = null;
    public $connection;
    
    protected function __construct() {
        
        //Initializing the database connection handler as required by Pixie
        $config = array(
            'driver'    => 'mysql', // Db driver
            'host'      => getenv('REST_API_PHP_DATABASE_HOST'),
            'database'  => getenv('REST_API_PHP_DATABASE_NAME'),
            'username'  => getenv('REST_API_PHP_DATABASE_USER'),
            'password'  => getenv('REST_API_PHP_DATABASE_PASSWORD'),
            'charset'   => 'utf8', // Optional
        );
        
        $conn = new Connection('mysql', $config);
        $this->connection = new QueryBuilderHandler($conn);
        
        if(empty($this->connection)){
            throw new DatabaseException;
        }
    }
    
    private function __clone() {
        
    }
    
    private function __wakeup() {
        
    }
    
    public function __destruct() {
        $this->connection = null;
    }
    
    public static function getInstance(){
        if(self::$instance == null){
            self::$instance = new self();
        }
        
        return self::$instance;
    }
    
    public function connection(){
        return $this->connection;
    }
    
    public function query($sql) {
        return mysqli_query($this->connection, $sql);
    }
    
}
