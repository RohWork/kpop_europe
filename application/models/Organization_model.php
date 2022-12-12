<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Organization_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
    }
 
    function insert_organization($organization){
        
        $params = array();
        
        $params['name'] = $organization;

        $params['writer'] = $this->session->userdata('name');        
        $params['regi_date'] = date('Y-m-d h:i:s');
                
        $this->db->insert('kpop_organization', $params);
        
        return $this->db->insert_id();
        
    }
    
    function get_organization(){
        
        
        $sSql = "SELECT idx, country_idx, name FROM `kpop_organization`";
        
        $query = $this->db->query($sSql);
        return $query->result_array();
        
    }
}