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
class Bank extends CI_Controller{
    public function __construct() {
        parent::__construct();
    } 
    public function index() {
        echo json_encode(
        array("message" => "No products found.","test"=>"asdas")
    );
    }
    
}
