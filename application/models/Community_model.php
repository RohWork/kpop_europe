<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Community_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
    }
    
    function get_list($search, $paging=""){
        
        $where = "";
        $limit = "";
        
        if(!empty($search['country'])){
            $where .= " AND country_idx ='".$search['country']."'";
        }
        if(!empty($search['city'])){
            $where .= " AND city_idx ='".$search['city']."'";
        }
        if(!empty($search['language'])){
            $where .= " AND language ='".$search['language']."'";
        }
        if(!empty($paging)){
            $limit = " limit ".$paging['start'].",".$paging['end'];
        }
        
        $sSql = "select kc.* , 
                (select count(*) from kpop_comment as kt where kt.community_idx = kc.idx ) as comment_cnt 
                from kpop_community as kc where 1=1 $where $limit";
        
        $query = $this->db->query($sSql);
        return $query->result_array();
    }
    
    function insert_community($params){
        
        
        $params['writer'] = $this->session->userdata('name');
        $params['regi_date'] = date('Y-m-d h:i:s');
        
        $this->db->insert('kpop_community', $params);
        
        return $this->db->insert_id();
    }
}