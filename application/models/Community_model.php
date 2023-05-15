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
        $params['reg_date'] = date('Y-m-d h:i:s');
        
        $this->db->insert('kpop_community', $params);
        
        return $this->db->insert_id();
    }
    
    function detail_community($idx){
        
        $sSql = "select kc.*, co.name as country_name, ci.name as city_name 
                from kpop_community as kc
                left join kpop_country as co on kc.country_idx = co.idx
                left join kpop_city as ci on kc.city_idx = ci.idx
                where idx = $idx order by kc.reg_date desc";
        
        $query = $this->db->query($sSql);
        return $query->row_array();
        
    }
    
    function comment_community($idx, $level){
        
        if($level == 1){
        
            $sSql = "select * from kpop_comment where community_idx = $idx order by reg_date";
        }else{
            $sSql = "select * from kpop_comment where community_idx = $idx and parent_idx is not null order by reg_date";
        }
        $query = $this->db->query($sSql);
        return $query->result_array();
    }
    
    function count_community($idx){
        
        $this->db->set('count', 'count + 1', false);
        
        $this->db->where("idx", $idx);
        $this->db->update('kpop_community', $params);
        
        return $this->db->affected_rows();
        
    }
}