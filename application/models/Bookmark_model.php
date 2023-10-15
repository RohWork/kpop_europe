<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Bookmark_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
    }
    
    public function list($user_id, $month){
        
        $sSql = "   SELECT ki.* ,kf.reg_date, kc.name AS country_name, kci.name AS city_name, ko.name AS organization_name
                    FROM `kpop_bookmark` as kf 
                    left join kpop_info as ki on kf.kpop_idx = ki.idx and ( ki.start_date like '$month%' or ki.end_date like '$month%' ) 
                    LEFT JOIN kpop_country AS kc ON kc.idx = ki.country_idx
                    LEFT JOIN kpop_city AS kci	ON kci.idx = ki.city_idx
                    LEFT JOIN kpop_organization AS ko ON ko.idx = ki.organization_idx 
                    where kf.state = '1' and user_id = '$user_id'  order by kf.idx desc";
        
        $query = $this->db->query($sSql);
        return $query->result_array();
        
        
    }
    
    
    public function insert($kpop_idx){
        
        $params = array();
        
        $params['user_id'] = $this->session->userdata('id');
        $params['kpop_idx'] = $kpop_idx;
        
        $params['reg_date'] = date('Y-m-d h:i:s');
        $this->db->insert('kpop_bookmark', $params);
        
        return $this->db->insert_id();
        
    }
    
    public function modify($params, $favorite_idx){
        
        
        $params['mod_date'] = date('Y-m-d h:i:s');
        
        $this->db->where("idx", $favorite_idx);
        $this->db->update('kpop_bookmark', $params);
        
        return $this->db->affected_rows();
        
    }
}