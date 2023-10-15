<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Favorite_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
    }
    
    public function list($user_id, $month){
        
        $sSql = "   SELECT ki.* ,kf.reg_date
                    FROM `kpop_bookmark` as kf 
                    left join kpop_info as ki on kf.kpop_idx = ki.idx and ki.reg_date like '$month%'
                    where state = '1' and user_id = '$user_id' and  order by ord asc, idx desc";
        
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