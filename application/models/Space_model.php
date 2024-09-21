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
        
        $sSql = "SELECT * FROM kpop_space as kp WHERE 1=1"
                . "left join kpop_country as ko on kc.country_idx = ko.idx "
                ."left join kpop_city as kc on kc.country_idx = ko.idx "
                . "where 1=1 $where";
        

        $query = $this->db->query($sSql);
        
        return $query->result_array();
        
    }
    
}
