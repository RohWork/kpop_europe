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
                $where .= " AND country_idx ='".$search['country']."'";
            }
        }
        if(!empty($search['city'])){
            if($search['city'] != 'all'){
                $where .= " AND .city_idx ='".$search['city']."'";
            }
        }
        
        $sSql = "SELECT * FROM kpop_space WHERE 1=1 $where";

        $query = $this->db->query($sSql);
        return $query->result_array();
        
    }
    
}
