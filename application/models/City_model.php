<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class City_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
    }
    
        function insert_city($params){
        

        $params['writer'] = $this->session->userdata('name');        
        $params['regi_date'] = date('Y-m-d h:i:s');
        
        $this->db->insert('kpop_city', $params);
        
        return $this->db->insert_id();
        
    }
    
    function get_city(){
        
        
            
        
        $sSql = "SELECT idx, country_idx, name FROM `kpop_city`";
        
        $query = $this->db->query($sSql);
        return $query->result_array();

        
    }
}