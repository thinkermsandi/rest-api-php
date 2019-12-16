<?php

namespace Api\Controller;

use Api\Core\Response;
use Api\Core\Constants;

use Api\Database\Mysql;

use Api\Model\Sample;
use Api\Model\User;

use Api\Util\Utils;

use Api\Exception\HttpForbiddenException;
use Api\Exception\HttpNotFoundException;
use Api\Exception\InsertException;
use Api\Exception\UpdateException;
use Api\Exception\DeleteException;

/**
 * A Sample class acting as guidance on how to implement the controller
 *
 * @author thinkermsandi
 */
class SampleController {
    
    private $user;
    private $db;
    
    public function __construct(User $user) {
        $this->user = $user;
        
        $sql = Mysql::getInstance();
        $this->db = $sql->connection();
    }
    
    public function samples($args) {
        
        //Perform Access Control first (if necessary)
        if($this->user->getRole() == Constants::$_USER_ACCOUNT_TYPE_GUEST){
            throw new HttpForbiddenException;
        }
        
        $samples = array();
        $pagination = array('total_results' => 0, 'total_pages' => 0, 'current_page' => 0);
        
        $page = $args['page'] ? $args['page'] : 0;
        $results_per_page = $args['results_per_page'] ? $args['results_per_page'] : Constants::$_DEFAULT_RESULTS_PER_PAGE;
        $limit = Utils::databaseLimitParams($page, $results_per_page);
        
        $samplesquery = $this->db->table(Constants::$_DATABASE_TABLE_SAMPLES)
            ->limit($limit['count'])
            ->offset($limit['start']);
        
        $samplesqueryresult = $samplesquery->get();
        foreach ($samplesqueryresult as $row) {
            //Populate the samples array
            $sample = array();
            array_push($samples, $sample);
        }
        
        $pagination['total_results'] = $samplesquery->count();
        $pagination['total_pages'] = ceil($pagination['total_results']/$limit['count']);
        $pagination['current_page'] = $page;
        
        $data = array('result' => 'success', 'samples' => $samples, 'pagination' => $pagination);
        Response::json($data);
        
    }
    
    /**
     * Method used to READ a specified resource using its ID
     * 
     * @param integer $id
     * @throws HttpForbiddenException
     * @throws HttpNotFoundException
     * 
     * @return object JSON object of sample
     */
    public function sample($id) {
        
        //Perform Access Control first (if necessary)
        if($this->user->getRole() == Constants::$_USER_ACCOUNT_TYPE_GUEST){
            throw new HttpForbiddenException;
        }
        
        //Perform database operations ie:
        $samplequery = $this->db->table(Constants::$_DATABASE_TABLE_SAMPLES)
            ->where('id', '=', $id);
        $row = $samplequery->first();
        
        if(empty($row)){
            throw new HttpNotFoundException;
        }
        
        //Populate sample array using information from $row
        $sample = array();
        
        $data = array('result' => 'success', 'sample' => $sample);
        Response::json($data);
        
    }
    
    /**
     * Method used to perform INSERT operations
     * 
     * @param type $args - sample data
     * 
     * @throws HttpForbiddenException
     * @throws InsertException
     */
    public function insertSample($args) {
        
        //Perform Access Control first (if necessary)
        if($this->user->getRole() == Constants::$_USER_ACCOUNT_TYPE_GUEST){
            throw new HttpForbiddenException;
        }
        
        $data1 = $args['data1'] ? $args['data1'] : 0;
        $data2 = $args['data2'] ? $args['data2'] : '';
        
        $sample = array(
            'data1' => $data1,
            'data2' => $data2,
        );
        
        $result = $this->db->table(Constants::$_DATABASE_TABLE_SAMPLES)
                ->insert($sample);
        
        if($result){
            $data = array('result' => 'success');
            Response::json($data);
        }
        else{
            throw new InsertException;
        }
        
    }
    
    /**
     * Method used to perform UPDATE operations
     * 
     * @param type $id - ID of the resource to update
     * @param type $args - sample data
     * 
     * @throws HttpForbiddenException
     * @throws UpdateException
     */
    public function updateSample($id, $args) {
        
        //Perform Access Control first (if necessary)
        if($this->user->getRole() == Constants::$_USER_ACCOUNT_TYPE_GUEST){
            throw new HttpForbiddenException;
        }
        
        $data1 = $args['data1'] ? $args['data1'] : 0;
        $data2 = $args['data2'] ? $args['data2'] : '';
        
        $sample = array(
            'data1' => $data1,
            'data2' => $data2,
        );
        
        $result = $this->db->table(Constants::$_DATABASE_TABLE_SAMPLES)
                ->where('id', '=', $id)
                ->update($sample);
        
        if($result){
            $data = array('result' => 'success');
            Response::json($data);
        }
        else{
            throw new UpdateException;
        }
        
    }
    
    /**
     * Method used to perform DELETE operations
     * 
     * @param type $id - ID of the resource to delete
     * @param type $args - any additional info to use
     * 
     * @throws HttpForbiddenException
     * @throws DeleteException
     */
    public function deleteSample($id, $args) {
        
        //Perform Access Control first (if necessary)
        if($this->user->getRole() == Constants::$_USER_ACCOUNT_TYPE_GUEST){
            throw new HttpForbiddenException;
        }
        
        //Perform the DELETE operation
        $result = $this->db->table(Constants::$_DATABASE_TABLE_SAMPLES)
                ->where('id', '=', $id)
                ->delete();
        
        if($result){
            $data = array('result' => 'success');
            Response::json($data);
        }
        else{
            throw new DeleteException;
        }
        
    }
    
}
