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
    
    function get_city( $country_idx = "" , $city_idx = "" ){
        
        $where = "";
        if(!empty($country_idx)){
            $where = "and kc.country_idx = $country_idx";
        }

        $sSql = "SELECT kc.*, ko.name as country_name FROM `kpop_city` as kc "
                . "left join kpop_country as ko on kc.country_idx = ko.idx "
                . "where kc.state = 1 $where order by kc.country_idx asc, ko.idx desc";
        
        $query = $this->db->query($sSql);
        return $query->result_array();
        
    }
    
    function get_city_idx($city){
        
        $where = "";
        
        if(!empty($city_idx)){
            $where = "and kc.idx = $city_idx";
        }
        $sSql = "SELECT kc.*, ko.name as country_name FROM `kpop_city` as kc "
                . "left join kpop_country as ko on kc.country_idx = ko.idx "
                . "where kc.state = 1 $where order by kc.country_idx asc, ko.idx desc";
        
        $query = $this->db->query($sSql);
        return $query->row_array();
    }
    
    function modify_city($params){
        
        $data = array();
        $data['name'] = $params['city'];
        $data['country_idx'] = $params['country_idx'];
        $data['modifier'] = $this->session->userdata('name');
        $data['modi_date'] = date('Y-m-d h:i:s');
        
        $this->db->where("idx", $params['idx']);
        $this->db->update('kpop_city', $data);
        
        return $this->db->affected_rows();
    }
}