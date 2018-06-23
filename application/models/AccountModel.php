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

//    public function validateAccountName($name,$gameID) {
    public function validateAccountName($name) {
//        $sql = "SELECT name FROM `bankaccount` where name='$name' and gameId='$gameID'";
        $sql = "SELECT name FROM `bankaccount` where name='$name' ";
        return count($this->db->query($sql)->result());
    }

    public function validateAccountNumber($accountNumber) {
        $sql = "SELECT accountNumber FROM `bankaccount` where accountNumber='$accountNumber'";
        if (count($this->db->query($sql)->result()) > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function createNewAccount($name) {
        $sql = "INSERT INTO `bankaccount` (`accountNumber`, `name`, `createdTime`, `updateTime`) VALUES (NULL, '$name', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
        $this->db->query($sql);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function deleteAccount($accountNumber) {

        $sql = "Delete FROM `bankaccount` where accountNumber='$accountNumber'";
        return $this->db->query($sql);
    }

    public function startgame() {
        $this->db->trans_start();
        $this->db->query("DELETE FROM `bankaccount` WHERE 1");
        $this->db->query("ALTER TABLE bankaccount  AUTO_INCREMENT=10001");
        return $this->db->trans_complete();
    }

    //updateGameId
    function updateGameID($oldId, $newId) {
        $sql = "update bankaccount set gameId='$newId' where gameId='$oldId'";
        $this->db->query($sql);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
