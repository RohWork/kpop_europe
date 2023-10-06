<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Country_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
    }
    
    public function list($user_id){
        
        $sSql = "SELECT * FROM `kpop_favorites` where state = '1' and user_id = '$user_id' order by ord asc, idx desc";
        
        $query = $this->db->query($sSql);
        return $query->result_array();
        
        
    }
    
    
    public function insert($kpop_idx){
        
        $params = array();
        
        $params['user_id'] = $this->session->userdata('id');
        $params['kpop_idx'] = $data['kpop_idx'];
        
        $params['regi_date'] = date('Y-m-d h:i:s');
        $this->db->insert('kpop_country', $params);
        
        return $this->db->insert_id();
        
    }
}