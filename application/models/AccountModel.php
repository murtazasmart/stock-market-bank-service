<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AccountModel
 *
 * @author Lalendra
 */
class AccountModel extends CI_Model {

    public function getAllAccount() {
        $sql = "SELECT * FROM `bankaccount`";
        return $this->db->query($sql)->result();
    }
    public function getAccountDetails($id) {
         $sql = "SELECT * FROM `bankaccount` where accountNumber='$id'";
        return $this->db->query($sql)->result();
    }

}
