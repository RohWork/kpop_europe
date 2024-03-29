<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Organization_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
    }
 
    function insert_organization($data){
        
        $params = array();
        
        $params['name'] = $data['organization'];
        $params['ord'] = $data['ord'];

        $params['writer'] = $this->session->userdata('name');        
        $params['regi_date'] = date('Y-m-d h:i:s');
                
        $this->db->insert('kpop_organization', $params);
        
        return $this->db->insert_id();
        
    }
    
    function modify_organization($data, $organization_idx){
        
        $params = array();
        
        $params['name'] = $data['organization'];
        $params['ord'] = $data['ord'];
        
        $params['modifier'] = $this->session->userdata('name');
        $params['modi_date'] = date('Y-m-d h:i:s');
        
        $this->db->where("idx", $organization_idx);
        $this->db->update('kpop_organization', $params);
        
        return $this->db->affected_rows();
        
    }
    
    function get_organization(){
        
        
        $sSql = "SELECT * FROM `kpop_organization` where state = 1 order by ord asc, idx desc";
        
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
    
    function delete_organization($idx){
        
        $this->db->where('idx', $idx);
        $this->db->delete('kpop_organization');
        
        return $this->db->affected_rows();
    }
}