<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Schedule_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
    }
    
    public function get_schedule($country, $year , $month){
       
        $sSql = "SELECT ki.name, DATE_FORMAT(ki.start_date,'%Y-%m-%d') AS start_date, DATE_FORMAT(ki.end_date,'%Y-%m-%d') AS end_date FROM kpop_info AS ki 
                 WHERE  LIKE '$year-$month%' AND ki.country ='$country'";
        
        $this->db->query($sSql);
        $this->db->result_array();
        
    }
    
}