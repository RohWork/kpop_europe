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
            $where .= " AND kc.country_idx ='".$search['country']."'";
        }
        if(!empty($search['city'])){
            $where .= " AND kc.city_idx ='".$search['city']."'";
        }
        if(!empty($search['language'])){
            $where .= " AND kc.language ='".$search['language']."'";
        }
        if(!empty($paging)){
            $limit = " limit ".$paging['start'].",".$paging['end'];
        }
        
        $sSql = "select kc.* , m.nick as mnick,
                (select count(*) from kpop_comment as kt where kt.community_idx = kc.idx ) as comment_cnt 
                from kpop_community as kc 
                left join kpop_member as m on kc.writer = m.id
                where kc.state = 1 $where $limit";
        
        $query = $this->db->query($sSql);
        return $query->result_array();
    }
    
    function insert_community($params){
        
        
        $params['writer'] = $this->session->userdata('id');
        $params['reg_date'] = date('Y-m-d H:i:s');
        
        $this->db->insert('kpop_community', $params);
        
        return $this->db->insert_id();
    }
    function modify_community($params, $idx){
        
        $params['mod_date'] = date('Y-m-d H:i:s');
        
        $this->db->where("idx", $idx);
        $this->db->update('kpop_community', $params);
        
        return $this->db->affected_rows();
    }
    function detail_community($idx){
        
        $sSql = "select kc.*, co.name as country_name, ci.name as city_name, m.nick as mnick
                from kpop_community as kc
                left join kpop_country as co on kc.country_idx = co.idx
                left join kpop_city as ci on kc.city_idx = ci.idx
                left join kpop_member as m on m.idx = kc.writer
                where kc.idx = $idx order by kc.reg_date desc";
        
        $query = $this->db->query($sSql);
        return $query->row_array();
        
    }
    
    function comment_community($idx, $level){
        
        if($level == 1){
            $where = " and km.parent_idx = 0";
        }else{
            $where = " and km.parent_idx != 0";
            
        }
        
        $sSql = "select km.*, m.nick as mnick from kpop_comment as km 
                left join kpop_member as m on km.writer = m.id
                where km.community_idx = $idx $where order by km.reg_date";
        
        $query = $this->db->query($sSql);
        return $query->result();
    }
    
    function count_community($idx){
        
        $this->db->set('cnt', 'cnt + 1', false);
        
        $this->db->where("idx", $idx);
        $this->db->update('kpop_community');
        
        return $this->db->affected_rows();
        
    }
    
    function like_community($idx, $mode){
        
        if($mode == "1"){
            $this->db->set('great', 'great + 1', false);
        }else{
            $this->db->set('hate', 'hate + 1', false);
        }
        
        $this->db->where("idx", $idx);
        $this->db->update('kpop_community');
        
        return $this->db->affected_rows();
        
    }
    
    function cancel_like_community($idx, $mode){
        
        if($mode == "1"){
            $this->db->set('great', 'great - 1', false);
        }else{
            $this->db->set('hate', 'hate - 1', false);
        }
        
        $this->db->where("idx", $idx);
        $this->db->update('kpop_community');
        
        return $this->db->affected_rows();
        
    }
    
    function insert_comment($params){
        
        
        $params['writer'] = $this->session->userdata('id');
        $params['reg_date'] = date('Y-m-d H:i:s');
        
        $this->db->insert('kpop_comment', $params);
        
        return $this->db->insert_id();
    }
    
    function modify_comment($params, $idx){
        
        
        $params['mod_date'] = date('Y-m-d H:i:s');
        
        $this->db->or_where("idx", $idx);
        $this->db->or_where("parent_idx", $idx);
        $this->db->update('kpop_comment', $params);
        
        return $this->db->affected_rows();
    }
    
    function like_comment($idx, $mode){
        
        if($mode == "1"){
            $this->db->set('great', 'great + 1', false);
        }else{
            $this->db->set('hate', 'hate + 1', false);
        }
        $this->db->where("idx", $idx);
        $this->db->update('kpop_comment');
        
        return $this->db->affected_rows();
        
    }
    
    function cancel_like_comment($idx, $mode){
        
        if($mode == "1"){
            $this->db->set('great', 'great - 1', false);
        }else{
            $this->db->set('hate', 'hate - 1', false);
        }
        $this->db->where("idx", $idx);
        $this->db->update('kpop_comment');
        
        return $this->db->affected_rows();
        
    }
    
    function set_like_history($idx, $mode, $type, $comment_idx){
        
        $params['id'] = $this->session->userdata('id');
        $params['mode'] = $mode; //1:좋아요, 2:싫어요 중 하나
        $params['board_type'] = $type; //comment, community 중 하나
        $params['board_idx'] = $idx;  
        $params['comment_idx'] = $comment_idx;  
        $params['reg_date'] = date('Y-m-d H:i:s');
        
        $this->db->insert('kpop_like_history', $params);
        
        return $this->db->insert_id();
    }
    
    function modify_like_history($idx, $mode, $type, $comment_idx){
        
        $this->db->set('state', '2' );
        
        $this->db->where("board_idx", $idx);
        $this->db->where("board_type", $type);
        $this->db->where("mode", $mode);
        
        $this->db->where("comment_idx", $comment_idx);
        
        $this->db->update('kpop_like_history');
        
       return $this->db->affected_rows();         
    }
    
    function get_like_history($idx, $type, $mode= "", $comment_idx){
        
        if(!empty($mode)){
            $mode_where = " and mode = $mode";
        }
        $id = $this->session->userdata('id');
        
        $sSql = "select * from kpop_like_history where board_idx = $idx and comment_idx = $comment_idx and board_type = '$type'".$mode_where." and id = '$id' and state = 1";
        
        $query = $this->db->query($sSql);
        return $query->result_array();
    }
    
    function get_comment_info($idx){
        
        $sSql = "select * from kpop_comment where idx = $idx"; 
        
        $query = $this->db->query($sSql);
        return $query->row();
    }
    
    
    
}