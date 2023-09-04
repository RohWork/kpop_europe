<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Schedule_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
    }
    
    public function get_schedule_cnt($search, $year , $month){
       
        $where = "";
        
        if(!empty($search['country'])){
            if($search['country'] != 'all'){
                $where .= " AND ki.country_idx ='".$search['country']."'";
            }
        }
        if(!empty($search['city'])){
            if($search['city'] != 'all'){
                $where .= " AND ki.city_idx ='".$search['city']."'";
            }
        }
        if(!empty($search['organizer'])){
            if($search['organizer'] != 'all'){
                $where .= " AND ki.organization_idx ='".$search['organizer']."'";
            }
        }
        
        if(!empty($search['type'])){
            if($search['type'] != 'all'){
                $where .= " AND ki.type ='".$search['type']."'";
            }
        }
        
        $sSql = "SELECT count(*) as cnt,DATE_FORMAT(ki.start_date,'%Y-%m-%d') AS start_date,DATE_FORMAT(ki.end_date,'%Y-%m-%d') AS end_date FROM kpop_info AS ki 
                 WHERE ki.start_date LIKE '$year-$month%'".$where."GROUP BY ki.start_date,ki.end_date";
        
        
        $query = $this->db->query($sSql);
        return $query->result_array();
        
    }
    
    public function get_duple_schedule_cnt($city, $space, $start){
        
        $sSql = "select count(*) as cnt from kpop_info where city_idx =  $city and space = '$space' and start_date >= '$start'";
        
        $query = $this->db->query($sSql);
        return $query->row()->cnt;
    }
    
    public function get_schedule($search, $paging=""){
       
        $where = "";
        $limit = "";
        
        if(!empty($search['country'])){
            $where .= " AND ki.country_idx ='".$search['country']."'";
        }
        if(!empty($search['city'])){
            $where .= " AND ki.city_idx ='".$search['city']."'";
        }
        if(!empty($search['organizer'])){
            $where .= " AND ki.organization_idx ='".$search['organizer']."'";
        }
        if(!empty($search['date'])){
            $where .= " and DATE_FORMAT(ki.start_date,'%Y-%m-%d') = '".$search['date']."'";
        }
        if(!empty($search['type'])){
            $where .= " AND ki.type ='".$search['type']."'";
        }
        if(!empty($paging)){
            $limit = "limit ".$paging['start'].",".$paging['end'];
        }
        
        $sSql = "SELECT ki.space, kc.name as country_name, ky.name as city_name, kz.name as organization_name , ki.name, DATE_FORMAT(ki.start_date,'%Y-%m-%d') AS start_date, DATE_FORMAT(ki.end_date,'%Y-%m-%d') AS end_date, ki.idx, ki.type as type FROM 
                    kpop_info AS ki 
                    left join kpop_country as kc on ki.country_idx = kc.idx
                    left join kpop_city as ky on ki.city_idx = ky.idx
                    left join kpop_organization as kz on ki.organization_idx = kz.idx
                 WHERE  1=1 ".$where." order by ki.end_date desc $limit";
        
        $query = $this->db->query($sSql);
        return $query->result_array();
        
    }
    public function get_detail_schedule($idx){
        
        $sSql = "SELECT ki.*, kc.name AS country_name, kci.name AS city_name, ko.name AS orgernizer FROM kpop_info AS ki 
                    LEFT JOIN kpop_country AS kc ON kc.`idx` = ki.`country_idx`
                    LEFT JOIN `kpop_city` AS kci ON kci.`idx` = ki.`city_idx`
                    LEFT JOIN `kpop_organization` AS ko ON ko.idx = ki.`organization_idx`
                    WHERE ki.idx = $idx ";
        
        $query = $this->db->query($sSql);
        return $query->row_array();
    }
    
    public function get_schedule_image($idx){
        
        $sSql = "SELECT * FROM kpop_gallery WHERE kpop_idx = $idx and state = 1";
        
        $query = $this->db->query($sSql);
        return $query->result_array();
    }
    function insert_schedule($params){
        
        
        $params['reg_date'] = date('Y-m-d h:i:s');
        $this->db->insert('kpop_info', $params);
        
        return $this->db->insert_id();
        
    }
    
    function modify_schedule($params, $idx){
        
        $this->db->where("idx" , $idx);
        $this->db->set($params);
        $this->db->update('kpop_info');
        
        return $this->db->affected_rows();
    }
    
    function delete_schedule($idx){
        
        $this->db->where('idx', $idx);
        $this->db->delete('kpop_info');
        
        return $this->db->affected_rows();
    }
    
    function set_schedule_image($kpop_idx){
        $this->db->where("kpop_idx" , $kpop_idx);
        $this->db->set("state", 2);
        $this->db->update('kpop_gallery');
        
        return $this->db->affected_rows();
    }
    
    function update_schedule_image($sort){
        
        $this->db->where("sort" , $sort);
        $this->db->set("state", 1);
        $this->db->update('kpop_gallery');
        
        return $this->db->affected_rows();
    }
    
    function select_schedule_image($src){
        $sSql = "SELECT count(*) as cnt FROM kpop_gallery WHERE src = '".$src."'";
        
        $query = $this->db->query($sSql);
        return $query->row_array();
    }
    
    function insert_schedule_image($params){
        
        $this->db->insert('kpop_gallery', $params);
        
        return $this->db->insert_id();
        
    }
}