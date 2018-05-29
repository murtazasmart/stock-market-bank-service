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
    
    public function balace($accountNumber) { 
        $sql="SELECT tble1.debit-tble1.credit as 'balace' from (SELECT sum(debit) as 'debit',SUM(credit) as 'credit' from transaction where accountnumber='$accountNumber') as `tble1`";
        $res= $this->db->query($sql)->result();
        return $res[0]->balace;
        
    }
    public function getBanakStatement($id) {
        $sql="SELECT tid,if(credit=0,'debit','credit') as 'type',if(credit=0,debit,credit) as 'amount',time,description FROM `transaction` WHERE accountnumber='$id' ORDER BY tid";
        return $this->db->query($sql)->result();
         
    }

}
