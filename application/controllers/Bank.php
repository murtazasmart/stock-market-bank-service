<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Bank
 *
 * @author Ulaleka
 */
class Bank extends CI_Controller {

    public function __construct() {
        
        parent::__construct();
         
       
    }
 
    public function index() { 
//        list($username, $password) = explode(':', base64_decode(substr($this->input->server('HTTP_AUTHORIZATION'), 6)));
        $api_key = $this->input->post('API-KEY');
        if ($api_key != "sdfwsdfds7d7sdsdfwsdfds7d7sd") {
           echo json_encode( array("status" => 'fail', "data" => NULL, "message" => "No access"));
        } else {
            echo json_encode(array("status" => 'success', "data" => array("test"=>1,"test2"=>2,), "message" => "test message"));
        }
    }
    public function createNewAccount() {
       $name=$this->input->post('name');
      
    }

}
