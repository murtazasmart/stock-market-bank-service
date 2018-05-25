<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MY_Controller
 *
 * @author Lalendra
 */
class MY_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
//        if (isset($_SERVER['HTTP_X_API_KEY'])) {
//            $key = $_SERVER['HTTP_X_API_KEY'];
//            if ($key != "612e648bf9594adb50844cad6895f2cf") {
//                echo json_encode(array("Status" => 'fail', "data" => NULL, "message" => 'API Key Wrong'));
//                die();
//            }
//        }  else {
//             echo json_encode(array("Status" => 'fail', "data" => NULL, "message" => 'Access Denied,Wrong API Key'));
//             die();
//        }
    }

}
