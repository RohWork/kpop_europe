<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Schedule_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
    }
    
    public function get_schedule($country, $year , $month){
       
        $sSql = "SELECT ki.name, DATE_FORMAT(ki.start_date,'%Y-%m-%d') AS start_date, DATE_FORMAT(ki.end_date,'%Y-%m-%d') AS end_date, ki.idx FROM kpop_info AS ki 
                 WHERE ki.start_date LIKE '$year-$month%' AND ki.country_idx ='$country'";
        
        $query = $this->db->query($sSql);
        return $query->result_array();
        
    }
    public function get_detail_schedule($idx){
        
        $sSql = "SELECT * FROM kpop_info WHERE idx = $idx ";
        
        $query = $this->db->query($sSql);
        return $query->row_array();
    }
    
    public function get_schedule_image($idx){
        
        $sSql = "SELECT * FROM kpop_gallery WHERE kpop_idx = $idx";
        
        $query = $this->db->query($sSql);
        return $query->result_array();
    }
    function insert_schedule($params){
        
        
        $params['reg_date'] = date('Y-m-d h:i:s');
        $this->db->insert('kpop_info', $params);
        
        return $this->db->insert_id();
        
    }
    
    function insert_schedule_image($params){
        
        $this->db->insert('kpop_gallery', $params);
        
        return $this->db->insert_id();
        
    }
}