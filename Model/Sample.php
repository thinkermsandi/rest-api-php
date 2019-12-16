<?php

namespace Api\Model;

/**
 * A class holding the Sample data and attributes
 */
class Sample {
    
    private $data1 = 0;
    private $data2 = '';
    

    public function setData1($data) {
        $this->data1 = $data;
    }
    
    public function setData2($data) {
        $this->data2 = $data;
    }
    
    public function getData1(){
        return $this->data1;
    }
    
    public function getData2(){
        return $this->data2;
    }
    
}
