<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Member_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
    }
    
    public function get_schedule($country, $year , $month){
       
        $sSql = "SELECT ki.company, ki.start_date, ki.end_date, ki.idx FROM kpop_info AS ki 
            WHERE ki.start_date LIKE '$year-$month%' AND ki.country ='$country'";
        
        $this->db->query($sSql);
        $this->db->result_array();
        
    }
    
}