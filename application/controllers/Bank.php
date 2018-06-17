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
        $this->load->model("TransactionModel");
    } 
    public function index(){
        echo "<h2>Bank API - UCD CS batch 7 final project_ team exit - https://github.com/murtazasmart/stock-market-bank-service</h2>";
    }

    public function account_get($id = NULL) {
//        $id = $this->get('id');

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

    public function account_post() {
        $inputJSON = file_get_contents('php://input');
        $input = json_decode($inputJSON, TRUE);
        $Name = $input['Name'];
        if ($Name == "" || $Name == NULL) {
            $this->response([
                'status' => FALSE,
                'message' => 'Invalid Account Name'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $count = $this->AccountModel->validateAccountName($Name);
            if ($count != 0) {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'Account name duplicate'
                        ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            } else {
                $accountNumber = $this->AccountModel->createNewAccount($Name);
                if ($accountNumber == '' || $accountNumber == NULL) {
                    $this->set_response([
                        'status' => FALSE,
                        'message' => 'Account Not Created'
                            ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
                } else {
                    $openBal = $this->TransactionModel->saveTransaction($accountNumber, '0.00', '1000.00', 'Opening Balance'); // opening balance
                    if ($openBal) {
                        $message = [
                            'accountNumber' => $accountNumber,
                            'Name' => $Name,
                            'message' => 'Added new account'
                        ];
                        $this->set_response($message, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
                    } else {
                        // account not created , unable to save opening bal
                        $this->AccountModel->deleteAccount($accountNumber);
                        $this->set_response([
                            'status' => FALSE,
                            'message' => 'Account Not Created'
                                ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
                    }
                }
            }
        }
    }
    public function account_delete($id=NULL) { 
        
        if ($id === NULL || $id <= 0) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Invalid request'
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
        }else{
            $validateAcount = $this->AccountModel->validateAccountNumber($id);
            if ($validateAcount) { //account number validate
                $this->AccountModel->deleteAccount($id);
                $message = [
                    'status' => TRUE,
                    'accountNumber'=>$id,
                     'message' => 'Account Removed'
                ];
                $this->set_response($message, REST_Controller::HTTP_OK);
            }else{
                $this->set_response([
                    'status' => FALSE,
                    'accountNumber'=>$id,
                    'message' => 'Account not found'
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function balance_get($id = NULL) {
//        $id = $this->get('id');


        if ($id === NULL || $id <= 0) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Invalid request'
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
        } else {
            $validateAcount = $this->AccountModel->validateAccountNumber($id);
            if ($validateAcount) { //account number validate
                $balance = $this->TransactionModel->balace($id);
                $message = [
                    'accountNumber' => $id,
                    'balace' => $balance,
                ];
                $this->set_response($message, REST_Controller::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'Account could not be found'
                        ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    //debit or credit 
    public function transaction_post() {
        $inputJSON = file_get_contents('php://input');
        $input = json_decode($inputJSON, TRUE);
        $type = $input['type'];
        $amount = $input['amount'];
        $accountNumber = $input['accountNumber'];
        $description = $input['description'];
        if ($type == "" || $amount == "" || $accountNumber == "" || !is_numeric($amount) || !is_numeric($accountNumber)) {
            //validate parameters
            $this->set_response([
                'status' => FALSE,
                'message' => 'Invalid request'
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
        } else {

            if (!($type == "credit" || $type == "debit")) { // type validate
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'Invalid Transaction type '
                        ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            }
            $validateAcount = $this->AccountModel->validateAccountNumber($accountNumber);

            if (!$validateAcount) { //account number validate
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'Account could not be found'
                        ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            } else {
                if ($type == "debit") {
                    $debit = $this->TransactionModel->saveTransaction($accountNumber, '0.00', $amount, $description);
                    if ($debit) {
                        $message = [
                            'accountNumber' => $accountNumber,
                            'message' => 'Transaction success'
                        ];
                        $this->set_response($message, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
                    } else {
                        $this->set_response([
                            'status' => FALSE,
                            'message' => 'Transaction Fail'
                                ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
                    }
                }
                if ($type == "credit") {
                    $balance = $this->TransactionModel->balace($accountNumber);
                    if ($balance < $amount) {
                        $this->set_response([
                            'status' => FALSE,
                            'message' => 'Transaction Fail,insufficient balance for this transaction !'
                                ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
                    } else {
                        $credit = $this->TransactionModel->saveTransaction($accountNumber, $amount, '0.00', $description);
                        if ($credit) {
                            $message = [
                                'accountNumber' => $accountNumber,
                                'message' => 'Transaction success'
                            ];
                            $this->set_response($message, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
                        } else {
                            $this->set_response([
                                'status' => FALSE,
                                'message' => 'Transaction Fail'
                                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
                        }
                    }
                }
            }
        }
    }

    public function statement_get($id = NULL) {
//        $id = $this->get('id');
        if ($id === NULL || $id <= 0) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Invalid request'
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
        } else {
            $validateAcount = $this->AccountModel->validateAccountNumber($id);


            if ($validateAcount) { //account number validate
                $st = $this->TransactionModel->getBanakStatement($id);
                $message = [
                    'accountNumber' => $id,
                    'data' => $st,
                ];
                $this->set_response($message, REST_Controller::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'Account could not be found'
                        ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    public function startgame_get() {
        $res = $this->AccountModel->startgame();
        if ($res) {
            $message = [
                'status' => 'success',
                'message' => 'Ready to start game'
            ];
            $this->set_response($message, REST_Controller::HTTP_OK); // NO_CONTENT (204) being the HTTP response code
        } else {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Not ready to start game'
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
        }
    }
    

}
