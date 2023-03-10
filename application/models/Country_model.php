<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Country_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
    }
    function insert_country($country){
        
        $params = array();
        
        $params['name'] = $country['country'];
        $params['writer'] = $this->session->userdata('name');
        $params['order'] = $country['order'];
        
        $params['regi_date'] = date('Y-m-d h:i:s');
        $this->db->insert('kpop_country', $params);
        
        return $this->db->insert_id();
        
    }
    
    function modify_country($data, $country_idx){
        
        $params = array();
        
        $params['name'] = $data['country'];
        $params['order'] = $data['order'];
        $params['modifier'] = $this->session->userdata('name');
        $params['modi_date'] = date('Y-m-d h:i:s');
        
        $this->db->where("idx", $country_idx);
        $this->db->update('kpop_country', $params);
        
        return $this->db->affected_rows();
        
    }
    
    function get_country(){
        
        $sSql = "SELECT * FROM `kpop_country` where state = '1' order by idx desc";
        
        $query = $this->db->query($sSql);
        return $query->result_array();

        
    }
    
    function get_country_idx($idx){
        
        $sSql = "SELECT * FROM `kpop_country` where state = '1' and idx = $idx order by idx desc";
        
        $query = $this->db->query($sSql);
        return $query->row_array();

        
    }
    
    function get_country_name($name){
        
        $sSql = "SELECT * FROM `kpop_country` where state = '1' and name = '$name' order by idx desc";
        
        $query = $this->db->query($sSql);
        return $query->row_array();

        
    }
    
    
    function delete_country($idx){
        
        $this->db->where('idx', $idx);
        $this->db->delete('kpop_country');
        
        return $this->db->affected_rows();
    }
}