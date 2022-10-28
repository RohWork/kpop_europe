<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Member_model extends CI_Model {
    
    
    function get_member($email){
        
        $sSql = "SELECT * FROM kpop_member WHERE email = '$email' ";
        
        $query = $this->db->query($sSql);
        return $query->row_array();
        
        
    }
    
    function set_id_member($id){
        
        $params = array(
            'state' => 1,
        );
        
        $this->db->where('id', $id);
        $this->db->update('member', $params);
        
        return $this->db->affected_rows();
    }
    
    function login_check_member($email, $pass){
        
        $sSql = "SELECT * FROM kpop_member WHERE email = '$email' and password = '$pass' ";
        
        $query = $this->db->query($sSql);
        return $query->row_array();
        
        
    }
    
    
    
    function set_member($params){
        
        

        $this->db->insert('kpop_member', $params);
        
        return $this->db->affected_rows();
        
    }
    
    
}

?>