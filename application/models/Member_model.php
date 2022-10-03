<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Member_model extends CI_Model {
    
    
    function get_member($email){
        
        $sSql = "SELECT * FROM kpop_member WHERE email = $email ";
        
        $query = $this->db->query($sSql);
        return $query->row_array();
        
        
    }
    
    
    function set_member($params){
        
        

        $this->db->insert('mytable', $params);
        
        return $this->db->affected_rows();
        
    }
    
    
}

?>