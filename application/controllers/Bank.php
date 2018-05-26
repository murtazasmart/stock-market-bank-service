<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Bank
 *
 * @author Lalendra
 */
require APPPATH . 'libraries/REST_Controller.php';

class Bank extends REST_Controller {

    function __construct() {     
        parent::__construct();
        $this->load->model("AccountModel");
    }

    public function account_get() {
        $id = $this->get('id');

        if ($id === NULL) {
            $accounts = $this->AccountModel->getAllAccount();

            if (!empty($accounts)) {
                // Set the response and exit
                $this->response($accounts, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No Account Found'
                        ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }

        $id = (int) $id;

        // Validate the id.
        if ($id <= 0) {
            // Invalid id, set the response and exit.
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }


        //getting account data
        $account = $this->AccountModel->getAccountDetails($id);


        if (!empty($account)) {
            $this->set_response($account, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            //account not found
            $this->set_response([
                'status' => FALSE,
                'message' => 'Account could not be found'
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

}
