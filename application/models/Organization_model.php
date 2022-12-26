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
    
    function modify_organization($organization, $organization_idx){
        
        $params = array();
        
        $params['name'] = $organization;
        $params['modifier'] = $this->session->userdata('name');
        $params['modi_date'] = date('Y-m-d h:i:s');
        
        $this->db->where("idx", $organization_idx);
        $this->db->update('kpop_organization', $params);
        
        return $this->db->affected_rows();
        
    }
    
    function get_organization(){
        
        
        $sSql = "SELECT * FROM `kpop_organization` where state = 1 order by idx desc";
        
        $query = $this->db->query($sSql);
        return $query->result_array();
        
    }
    
    function get_organization_idx($idx){
        
        $sSql = "SELECT * FROM `kpop_organization` where state = 1 and idx=$idx";
        
        $query = $this->db->query($sSql);
        return $query->row_array();
        
    }
    
    function get_organization_name($name){
        
        $sSql = "SELECT * FROM `kpop_organization` where state = 1 and name='$name'";
        
        $query = $this->db->query($sSql);
        return $query->row_array();
        
    }
}