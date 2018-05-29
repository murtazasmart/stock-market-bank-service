<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TransactionModel
 *
 * @author Lalendra
 */
class TransactionModel extends CI_Model {

    public function saveTransaction($accountNumber, $credit, $debit, $description) {
        $sql = "INSERT INTO `transaction`( `accountnumber`, `credit`, `debit`, `description`) VALUES ('$accountNumber','$credit','$debit','$description')";
        return $this->db->query($sql);
    }

}
