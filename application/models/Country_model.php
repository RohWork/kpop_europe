<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Country_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
    }
    function insert_country($country){
        
        $params = array();
        
        $params['name'] = $country;
        $params['writer'] = $this->session->userdata('name');
        
        $params['regi_date'] = date('Y-m-d h:i:s');
        $this->db->insert('kpop_country', $params);
        
        return $this->db->insert_id();
        
    }
    
    function modify_country($country, $country_idx){
        
        $params = array();
        
        $params['name'] = $country;
        $params['modifier'] = $this->session->userdata('name');
        $params['modi_date'] = date('Y-m-d h:i:s');
        
        $this->db->where("idx", $country_idx);
        $this->db->update('kpop_country', $params);
        
        return $this->db->affected_rows();
        
    }
    
    function get_country($idx = ""){
        
        $where = "";
        if(!empty($idx)){
            $where  = "and idx = ".$idx;
        }
        
        $sSql = "SELECT * FROM `kpop_country` where state = '1' $where order by idx desc";
        
        $query = $this->db->query($sSql);
        return $query->result_array();

        
    }
}