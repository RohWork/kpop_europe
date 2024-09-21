<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Space_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
    }
    
    function get_space($search){
        
        $where = "";
        
        if(!empty($search['country'])){
            if($search['country'] != 'all'){
                $where .= " AND kp.country_idx ='".$search['country']."'";
            }
        }
        if(!empty($search['city'])){
            if($search['city'] != 'all'){
                $where .= " AND kp.city_idx ='".$search['city']."'";
            }
        }
        
        $sSql = "SELECT kp.*, kc.name as country_name, kc.name as city_name FROM kpop_space as kp "
                . "left join kpop_country as ko on kp.country_idx = ko.idx "
                ."left join kpop_city as kc on kp.city_idx = kc.idx "
                . "where 1=1 $where";
        

        $query = $this->db->query($sSql);
        
        return $query->result_array();
        
    }
    
    
    function get_space_idx($idx){
        
        $where = "";
        
        if(!empty($city_idx)){
            $where = "and kc.idx = $city_idx";
        }
        $sSql = "SELECT kp.*, kc.name as country_name, kc.name as city_name FROM kpop_space as kp "
                . "left join kpop_country as ko on kp.country_idx = ko.idx "
                ."left join kpop_city as kc on kp.city_idx = kc.idx "
                . "where 1=1 $where";
        
        $query = $this->db->query($sSql);
        return $query->row_array();
        
        
    }
    
}
