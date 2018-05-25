<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Account
 *
 * @author Lalendra
 */
class Account extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("AccountModel");
    }

    public function index() {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == 'GET') {

            if ($this->input->get('id') != '') {
                $id = $this->input->get('id');
                $this->getAccountDetails($id);
            } else {
                $this->getAll();
            } 
        } elseif ($method == 'POST') {
            
        } elseif ($method == "PUT") {
            
        } else {
            echo json_encode(array("Status" => 'fial', "data" => array(), "message" => "Undifine Request"));
        }
    }

    public function Put() {
        
    }

    private function getAll() {
        try {
            $accounts = $this->AccountModel->getAllAccount();
            echo json_encode(array("Status" => 'success', "data" => $accounts, "message" => 'account list'));
        } catch (Exception $e) {
            echo json_encode(array("Status" => 'fial', "data" => array(), "message" => $e));
        }
    }

    private function getAccountDetails($id) {
        try {
            $accounts = $this->AccountModel->getAccountDetails($id);
                if(count($accounts)){
                    echo json_encode(array("Status" => 'success', "data" => $accounts, "message" => 'account details'));
                }  else {
                    echo json_encode(array("Status" => 'success', "data" => $accounts, "message" => 'No record found'));
                }
            
        } catch (Exception $e) {
            echo json_encode(array("Status" => 'fial', "data" => array(), "message" => $e));
        }
    }

}
